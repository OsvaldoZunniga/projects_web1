CREATE TABLE roles(
    idRoles INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombreRol VARCHAR(50) NOT NULL
);

CREATE TABLE usuarios(
    idUsuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL,
    nacimiento DATE NOT NULL,
    correo VARCHAR(50) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fotografia VARCHAR(300),
    estado VARCHAR(30) DEFAULT 'Pendiente',
    contrasena VARCHAR(300) NOT NULL,
    idRoles INT NOT NULL, 
    CONSTRAINT fk_usuarios_roles FOREIGN KEY (idRoles) REFERENCES roles(idRoles)
);

CREATE TABLE vehiculos(
    idVehiculo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT NOT NULL,
    placa VARCHAR(20) NOT NULL,
    color VARCHAR(20) NOT NULL,
    marca VARCHAR(20) NOT NULL,
    modelo VARCHAR(20) NOT NULL,
    anio VARCHAR(10) NOT NULL,
    capacidad INT NOT NULL,
    foto VARCHAR(300),
    CONSTRAINT fk_vehiculos_usuarios FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE TABLE ride(
    idRide INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idVehiculo INT NOT NULL,
    nombre VARCHAR(100) NOT NULL, 
    salida VARCHAR(150) NOT NULL,
    llegada VARCHAR(150) NOT NULL,
    hora TIME NOT NULL,
    fecha DATE NOT NULL,
    espacios INT NOT NULL,
    costo_espacio DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_ride_vehiculos FOREIGN KEY (idVehiculo) REFERENCES vehiculos(idVehiculo)
);

CREATE TABLE reserva(
    idReserva INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idRide INT NOT NULL,
    idUsuario INT NOT NULL,
    CONSTRAINT fk_reserva_usuarios FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario),
    CONSTRAINT fk_reserva_ride FOREIGN KEY (idRide) REFERENCES ride(idRide)
);