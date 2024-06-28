CREATE DATABASE bdviajes; 

USE bdviajes;
CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona(
    documento bigint,
    nombre varchar(50),
    apellido varchar(50),
    PRIMARY KEY (documento)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE responsable (
    idResponsable bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    rdocumento bigint,
    /*
	rnombre varchar(150), 
    rapellido  varchar(150),
    */
    PRIMARY KEY (idResponsable),
    FOREIGN KEY (rdocumento) REFERENCES persona (documento)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros bigint,
	idempresa bigint,
    idResponsable bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (idResponsable) REFERENCES responsable (idResponsable)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    idpasajero bigint AUTO_INCREMENT,
    pdocumento bigint,
    /*
    pnombre varchar(150), 
    papellido varchar(150),
    */
	ptelefono bigint, 
	idviaje bigint,
    PRIMARY KEY (idpasajero),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (pdocumento) REFERENCES persona (documento)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1; 
 
  
