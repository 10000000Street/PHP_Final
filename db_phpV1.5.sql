drop schema db_php;
create schema db_php;
use db_php;
create table Persona(
	ci int primary key, 
    nombres varchar(50) NOT NULL, 
    apellidos varchar(50) NOT NULL,
    foto varchar(255) NOT NULL,
	pin char(32) NOT NULL,
    desactivada boolean);

create table Encargado (
	ci int primary key,
	email varchar(50) NOT NULL,
	FOREIGN KEY (ci) REFERENCES Persona(ci) 
) ;

create table Transportista (
	ci int primary key,
	direccion varchar(50) NOT NULL,
	telefono int NOT NULL,
	FOREIGN KEY (ci) REFERENCES Persona(ci) on update cascade
 ) ;
 
create table Paquete (
	codigo varchar(13) primary key, 
	direccion_remitente varchar(100) not null, 
	direccion_envio varchar(100) not null, 
	fragil boolean not null, 
	perecedero boolean not null, 
	fecha_entrega date, 
	estado smallint not null check (estado BETWEEN -1 and 1)
 );
 
 create table Asignaciones(
	codigo varchar(13) not null,
    ci int not null,
	fecha_estimada_entrega date not null, 
	fecha_hora_asignacion datetime not null,
    foreign key (codigo) references Paquete(codigo),
    foreign key (ci) references Transportista(ci),
	primary key (codigo,ci) /* planeo que la clave primaria solo sea el codigo del paquete*/ 
);

/* INSERT Personas */

INSERT INTO Persona VALUES
(48488430,'Federico','Méndez Olivera','73643802n0.jpg','e10adc3949ba59abbe56e057f20f883e',false),
(5340339,'Tadeo','Goday','87963526n0.jpg','e10adc3949ba59abbe56e057f20f883e',false),
(44956533,'Clemente','Chen','44956533n0.jpg','b776ef5ff96773dc22822c6fe4702b13',false),
(07242161,'Jesus Miguel','Castellano','7242161n0.jpg','9409d561228e6469d79b923f08bbbc08',false),

(79041860,'Isidro','Velez','79041860n0.jpg','b0477b804684ad106a9d97bb8a2fd143',false),
(28853514,'Carlos Enrique','Oliveira','28853514n0.jpg','df3efb838fa90ec0a2f9e98eea4df89f',false),
(63737420,'Mauricio','Fuentes','63737420n0.jpg','2a31da6a505d1b300685a8203ad01d12',false),
(92416532,'Simon','Roldan','92416532n0.jpg','5231ee3a4914171201f7e5484cc2f23a',false);
/*
INSERT INTO Persona VALUES
(48488430,'Tomas','Merino','48488430n0.jpg','123456'),
(5340339,'Antoni','Encinas','87963526n0.jpg','123456'),
(44956533,'Clemente','Chen','44956533n0.jpg','RmYCMw'),
(07242161,'Jesus Miguel','Castellano','7242161n0.jpg','HQ6WCE'),

(79041860,'Isidro','Velez','79041860n0.jpg','BYnVpE'),
(28853514,'Carlos Enrique','Oliveira','28853514n0.jpg','A8PFWq'),
(63737420,'Mauricio','Fuentes','63737420n0.jpg','qn6FQ9'),
(92416532,'Simon','Roldan','92416532n0.jpg','XTczHH'); */

INSERT INTO Encargado VALUES
(48488430,'fededemende@gmail.com'),
(5340339,'tadeo.goday@gmail.com '),
(44956533,'php.ude@gmail.com'),
(07242161,'re_boludeable@hotmail.com');

INSERT INTO Transportista VALUES
(79041860,'Zucara 1462',33413542),
(28853514,'Bv. Jose Batlle y Ordoñez 4196',94965081),
(63737420,'Canelones 8416',47724947),
(92416532,'Av. Gonzalo Ramirez 4123',17100422);

INSERT INTO Paquete(codigo,direccion_remitente,direccion_envio,fragil,perecedero,fecha_entrega,estado) VALUES 
	('UA630298575US', 'Fray Bentos 3552','Constitución 1781', false, false,null,-1),
    ('NN123456789CN', 'Av. Mcal. Fco. Solano López 1774','Itapebi 2204', false, false,null,-1),
    
    ('UA631173020US', 'Basilio Araujo 3985', 'Dr Martín Casimiro Martínez 1954', false, false,null,0),
    ('RT907538385HK', 'Dr Vicente Basagoity 3930', 'Adolfo Berro 826', false, false,null,0),
    
    ('RV968381015CN', 'Solano García 2545', 'San Fructuoso 834', false, false,'2020-06-18',1);
    
INSERT INTO Asignaciones VALUES 
	('RV968381015CN',79041860,'2020-06-17','2020-06-10 20:08:51'),
    
	('UA631173020US',28853514,'2020-06-14','2020-06-08 11:20:15'),
	('RT907538385HK',92416532,'2020-05-01','2020-04-25 17:18:25');
    
/* PROCEDURES */

DELIMITER $$;
Create procedure finalizarEnvio(p_transportista int ,OUT p_error int)
BEGIN
	Declare a_codigo varchar(13) ;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
		BEGIN
			set p_error=-1;
			ROLLBACK;
		END;
	IF (select count(*) from Asignaciones a, Paquete p where a.codigo=p.codigo and ci=p_transportista and p.estado=0) =1 THEN
		begin
			Start transaction;
            set a_codigo=(select p.codigo from Asignaciones a, Paquete p where a.codigo=p.codigo and ci=p_transportista and p.estado=0);
			update Paquete set fecha_entrega=CURDATE(), estado=1 where codigo=a_codigo;
            COMMIT;
			set p_error=0;
		end;
	ELSE 
		BEGIN
			IF (select count(*) from Asignaciones a, Paquete p where a.codigo=p.codigo and ci=p_transportista and p.estado=0) >1 THEN
				set p_error=-2;
			END IF;
		END;
	END IF;
END$$;

Delimiter $$;
create procedure asignarPaquete(p_transportista int ,p_paquete varchar(13),p_fecha_estimada date,out p_error int)
	BEGIN 
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
			BEGIN
				set p_error=-1;
				ROLLBACK;
			END;
		IF /* reviso que el paquete siga estando sin asignar y reviso que el transportista no tenga un paquete activo */
			(select count(*) from paquete where codigo=p_paquete and estado=-1)=1 
			AND 
			(select count(*) from Paquete p left outer join  Asignaciones a on (a.codigo=p.codigo) where estado=0 and ci=p_transportista)=0 
			then 
				begin
					start transaction;
						insert into Asignaciones values( p_paquete,p_transportista,p_fecha_estimada,current_timestamp() );
						update Paquete set estado=0 where codigo=p_paquete;
						set p_error=0;
					commit;
				end;
		ELSE 
			set p_error=-2;
		END IF;
    END$$;

Delimiter $$;
create procedure agregarTransportista(p_ci int,p_nombres varchar(50), p_apellidos varchar(50), p_foto varchar(255),p_pin char(32),p_direccion varchar(50),p_telefono int,out p_error int)
	begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
				BEGIN
					set p_error=-1;
					ROLLBACK;
				END;
		if p_ci is not null and p_nombres is not null and p_apellidos is not null and p_foto is not null and p_pin is not null and p_direccion is not null and p_telefono is not null then
			if (select count(*) from Persona where ci=p_ci)=0 then
				begin	
					start transaction;
						insert into Persona values (p_ci,p_nombres,p_apellidos,p_foto,p_pin,false);
						insert into Transportista values (p_ci,p_direccion,p_telefono);
					commit;
					set p_error=0;
				end;
			else 
				set p_error=-2; /* ya hay una ci registrada*/
			end if;
		else 
			set p_error=-3; /* parametros null*/ 
		end if;
	end$$;
    
Delimiter $$;
create procedure modificarTransportista(p_ci int,p_new_ci int,p_nombres varchar(50), p_apellidos varchar(50), p_foto varchar(255) ,p_pin char(32),p_direccion varchar(50),p_telefono int,out p_error int)
begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
				BEGIN
					set p_error=-1;
					ROLLBACK;
				END;
		if (select count(*) from Transportista where ci=p_ci)=1 then
			if (select count(*) from Transportista where ci=p_new_ci)=0 then /* sea null o sea una nueva cedula, lo va a frenar si encuentra algo*/
				begin	
					start transaction;
						if(p_nombres is not null) then update Persona set nombres=p_nombres where ci=p_ci; 				end if;
						if(p_apellidos is not null) then update Persona set apellidos=p_apellidos where ci=p_ci;				end if;
						if(p_pin is not null) then update Persona set pin=p_pin where ci=p_ci;										end if;
                        
                        if(p_foto is not null) then update Persona set foto=p_foto where ci=p_ci;									end if;
						
						if(p_direccion is not null) then update Transportista set direccion=p_direccion where ci=p_ci;		end if;
						if(p_telefono is not null) then update Transportista set telefono=p_telefono where ci=p_ci;			end if;
						
						if(p_new_ci is not null) then update Persona set ci=p_new_ci where ci=p_ci;								end if;
                        
					commit;
					set p_error=0;
				end;
            else 
				set p_error=-2;
			end if;
		else 
			set p_error=-3;
        end if;
	end$$;
    
Delimiter $$;
create procedure desactivarTransportista(p_ci int, out p_error int)
	begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
			BEGIN
				set p_error=-1;
				ROLLBACK;
			END;
		if(select count(*) from Transportista t, Persona p where p.ci=t.ci and t.ci=p_ci AND p.desactivada=false)=1 then 
			begin
				declare codigoPaquete varchar(13); 
                set codigoPaquete =(select p.codigo from Paquete p left outer join Asignaciones a on (a.codigo=p.codigo) where p.estado=0 and a.ci=p_ci);
                
				start transaction;
					update Persona set desactivada=true where ci=p_ci;
					delete from Asignaciones where codigo=codigoPaquete;
					update Paquete set estado=-1 where codigo=codigoPaquete;
                commit;
                set p_error=0;
			end;
		else 
			set p_error=-2;
        end if;
    end$$;

Delimiter $$;    
create procedure reactivarTransportista(p_ci int, out p_error int)
	begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
			BEGIN
				set p_error=-1;
				ROLLBACK;
			END;
		if(select count(*) from Transportista t, Persona p where p.ci=t.ci and t.ci=p_ci AND p.desactivada=true)=1 then 
			begin
				start transaction;
				update Persona set desactivada=false where ci=p_ci;
                commit;
                set p_error=0;
			end;
		else 
			set p_error=-2;
        end if;
    end$$;
    
/*******************
     PAQUETE  
********************/

	codigo varchar(13) primary key, 
	direccion_remitente varchar(100) not null, 
	direccion_envio varchar(100) not null, 
	fragil boolean not null, 
	perecedero boolean not null, 
	fecha_entrega date, 
	estado smallint not null check (estado BETWEEN -1 and 1)
    
Delimiter $$;
create procedure agregarPaquete(p_cod varchar(13),p_direcRemitente varchar(100), p_direcEnvio varchar(100), p_fragil boolean,p_perecedero boolean,out p_error int)
	begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
				BEGIN
					set p_error=-1;
					ROLLBACK;
				END;
		if p_cod is not null and p_direcRemitente is not null and p_direcEnvio is not null and p_fragil is not null and p_perecedero is not null then
			if (select count(*) from Paquete where codigo=p_cod)=0 then
				begin	
					start transaction;
						insert into Paquete values (p_cod,p_direcRemitente,p_direcEnvio,p_fragil,p_perecedero,null,-1);
					commit;
					set p_error=0;
				end;
			else 
				set p_error=-2; /* paquete preexistente */
			end if;
		else 
			set p_error=-3; /* campos nulls*/
		end if;
	end$$;
    
Delimiter $$;
create procedure eliminarPaquete(p_cod varchar(13), out p_error int)
	begin
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
			BEGIN
				set p_error=-1;
				ROLLBACK;
			END;
		if( select count(*) from Paquete where codigo=p_cod and estado=-1) =1 then 
			begin
				start transaction;
					DELETE from Paquete where codigo=p_cod;
                commit;
                set p_error=0;
			end;
		else 
			set p_error=-2;
        end if;
    end$$;
    
Delimiter $$;
create procedure modificarPaquete(p_cod varchar(13),p_new_cod varchar(13),p_direcRemitente varchar(100), p_direcEnvio varchar(100), p_fragil boolean,p_perecedero boolean,out p_error int)
begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
				BEGIN
					set p_error=-1;
					ROLLBACK;
				END;
		if p_cod is not null and (select count(*) from Paquete where codigo=p_new_cod)=0 then
			if (select count(*) from Paquete where codigo=p_cod and estado=-1) =1 and (select count(*) from Asignaciones where codigo=p_cod)=0 then
				begin	
					start transaction;
						if(p_direcRemitente is not null) 	then update Paquete set direccion_remitente=p_direcRemitente 	where codigo=p_cod; 	end if;
						if(p_direcEnvio is not null)			then update Paquete set direccion_envio=p_direcEnvio 				where codigo=p_cod;	end if;
						if(p_fragil is not null) 				then update Paquete set fragil=p_fragil 										where codigo=p_cod;	end if;
						if(p_perecedero is not null)		then update Paquete set perecedero=p_perecedero 					where codigo=p_cod;	end if;
						if(p_new_cod is not null) 			then update Paquete set codigo=p_new_cod								where codigo=p_cod;	end if;
					commit;
					set p_error=0;
				end;
			else 
				set p_error=-2;
			end if;
		else 
			set p_error=-3;
		end if;
	end$$;