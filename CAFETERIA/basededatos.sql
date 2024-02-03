
CREATE TABLE id20513538_cafeteria_mineral_del_monte.roles (
	id 		INT  		NOT NULL  AUTO_INCREMENT,
	rol 	VARCHAR(50) NOT NULL,
	
	CONSTRAINT pk_roles PRIMARY KEY (id)
);

INSERT INTO compania.empleado VALUES (gerente);
INSERT INTO compania.empleado VALUES (empleado);
INSERT INTO compania.empleado VALUES (usuario);


CREATE TABLE id20513538_cafeteria_mineral_del_monte.usuarios (
    id       		INT       		NOT NULL  AUTO_INCREMENT,
    nombre        	VARCHAR(20)     NOT NULL,
    apellido     	VARCHAR(20),
	email 			VARCHAR(50)     NOT NULL,
	edad 			INT,
	nombreUsuario 	VARCHAR(20)     NOT NULL,
	password 		VARCHAR(255) 	NOT NULL,
	activationcode 	VARCHAR(255)	NOT NULL,
	status			INT(11) 		NOT NULL,
	idRol		 	INT 			NOT NULL,

	CONSTRAINT pk_usuario PRIMARY KEY (id,nombreUsuario),
	CONSTRAINT fk_idRol FOREIGN KEY (idRol) REFERENCES id20513538_cafeteria_mineral_del_monte.roles(id)
);


CREATE TABLE id20513538_cafeteria_mineral_del_monte.ingrediente (
	id 				 INT 	    		NOT NULL  AUTO_INCREMENT,
	nombre 		 	 VARCHAR(25) 		NOT NULL,
	fechaCaducidad 	 DATE 		 		NOT NULL,
	cantidad 		 INT				NOT NULL,
	
	CONSTRAINT pk_ingrediente PRIMARY KEY (id)
);

CREATE TABLE id20513538_cafeteria_mineral_del_monte.producto (
	id 				 INT 	    		NOT NULL  AUTO_INCREMENT,
	nombre 		 	 VARCHAR(25) 		NOT NULL,
	descripcion 	 VARCHAR(25) 		NOT NULL,
	gramos 	  		 INT 				NOT NULL,
	precio 	  		 INT 				NOT NULL,
	cantidad 		 INT				NOT NULL,
	imagen 			 VARCHAR(255) 		NOT NULL,
	categoria 		 enum('bebidascalientes', 'especialidad', 'bebidasfrias','alimentos'),
	
	CONSTRAINT pk_producto PRIMARY KEY (id)
);

CREATE TABLE id20513538_cafeteria_mineral_del_monte.productoIngrediente (
	id 				 INT 	    NOT NULL  AUTO_INCREMENT,
	idProducto	 	 INT 		NOT NULL,
	idIngrediente 	 INT 		NOT NULL,
	
	CONSTRAINT pk_productoIngrediente PRIMARY KEY (id),
	CONSTRAINT fk_idProducto FOREIGN KEY (idProducto) REFERENCES id20513538_cafeteria_mineral_del_monte.producto(id),
	CONSTRAINT fk_idIngrediente FOREIGN KEY (idIngrediente) REFERENCES id20513538_cafeteria_mineral_del_monte.ingrediente(id)
);

CREATE TABLE id20513538_cafeteria_mineral_del_monte.notificaciones (
	id 				 INT 	    	NOT NULL  AUTO_INCREMENT,
	fechaPublicacion DATE 			NOT NULL,
	descripcion 	 VARCHAR(300)  	NOT NULL,
	estado 			 INT,
	nombre 			 VARCHAR(25),
	idUsuario 		 INT 			NOT NULL,
	idEmpleado		 INT			NOT NULL,
	idGerente		 INT 			NOT NULL,
	
	CONSTRAINT pk_notificaciones PRIMARY KEY (id),
	CONSTRAINT fk_idUsuario FOREIGN KEY (idUsuario) REFERENCES id20513538_cafeteria_mineral_del_monte.usuarios(id),
	CONSTRAINT fk_idEmpleado FOREIGN KEY (idEmpleado) REFERENCES id20513538_cafeteria_mineral_del_monte.usuarios(id),
	CONSTRAINT fk_idGerente_notificacion FOREIGN KEY (idGerente) REFERENCES id20513538_cafeteria_mineral_del_monte.usuarios(id)
);


