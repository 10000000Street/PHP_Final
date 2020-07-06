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
	FOREIGN KEY (ci) REFERENCES Persona(ci) 
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
	primary key (codigo,ci)
);

/* INSERT Personas */

INSERT INTO Persona VALUES
(73643802,'Tomas','Merino','N/A','91f071452abaa5c84707643da58352c4',false),
(87963526,'Antoni','Encinas','N/A','e536f72e36f9164150947a1a06ee3dcf',false),
(44956533,'Clemente','Chen','N/A','b776ef5ff96773dc22822c6fe4702b13',false),
(07242161,'Jesus Miguel','Castellano','N/A','9409d561228e6469d79b923f08bbbc08',false),

(79041860,'Isidro','Velez','N/A','b0477b804684ad106a9d97bb8a2fd143',false),
(28853514,'Carlos Enrique','Oliveira','N/A','df3efb838fa90ec0a2f9e98eea4df89f',false),
(63737420,'Mauricio','Fuentes','N/A','2a31da6a505d1b300685a8203ad01d12',false),
(92416532,'Simon','Roldan','N/A','5231ee3a4914171201f7e5484cc2f23a',false);
/*
INSERT INTO Persona VALUES
(73643802,'Tomas','Merino','N/A','qGx4Yn'),
(87963526,'Antoni','Encinas','N/A','B3J4Eg'),
(44956533,'Clemente','Chen','N/A','RmYCMw'),
(07242161,'Jesus Miguel','Castellano','N/A','HQ6WCE'),

(79041860,'Isidro','Velez','N/A','BYnVpE'),
(28853514,'Carlos Enrique','Oliveira','N/A','A8PFWq'),
(63737420,'Mauricio','Fuentes','N/A','qn6FQ9'),
(92416532,'Simon','Roldan','N/A','XTczHH'); */

INSERT INTO Encargado VALUES
(73643802,'fenomen4k@gmail.com'),
(87963526,'sketiitboy_@outlook.com'),
(44956533,'$antana@hotmail.com'),
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


/**************************************************
     Encargado
**************************************************/
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
create procedure modificarTransportista(p_ci int,p_new_ci int,p_nombres varchar(50), p_apellidos varchar(50), p_foto varchar(255),p_pin char(32),p_direccion varchar(50),p_telefono int,out p_error int)
begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
				BEGIN
					set p_error=-1;
					ROLLBACK;
				END;
		if (select count(*) from Transportista where ci=p_ci)=1 then
			begin	
				start transaction;
					if(p_nombres is not null) then update Persona set nombres=p_nombres where ci=p_ci; 				end if;
                    if(p_apellidos is not null) then update Persona set apellidos=p_apellidos where ci=p_ci;				end if;
                    if(p_foto is not null) then update Persona set foto=p_foto where ci=p_ci;									end if;
                    if(p_pin is not null) then update Persona set pin=p_pin where ci=p_ci;										end if;
                    
                    if(p_direccion is not null) then update Transportista set direccion=p_direccion where ci=p_ci;		end if;
                    if(p_telefono is not null) then update Transportista set telefono=p_telefono where ci=p_ci;			end if;
                    
                    if(p_new_ci is not null) then update Persona set ci=p_new_ci where ci=p_ci;								end if;
				commit;
                set p_error=0;
            end;
		else 
			set p_error=-2;
        end if;
	end$$;
    
Delimiter $$;
create procedure desactivarTransportista(p_ci int, out p_error int)
	begin
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
			BEGIN
				ROLLBACK;
			END;
		if(select count(*) from Transportista t, Persona p where p.ci=t.ci and t.ci=p_ci AND p.desactivada=false)=1 then 
			begin
				start transaction;
				update Persona set desactivada=true where ci=p_ci;
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