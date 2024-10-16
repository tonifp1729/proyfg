-- CREACIÓN DE TABLAS
-- Crear tabla Administrador
CREATE TABLE Administrador (
    correo VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL CHECK (LENGTH(contrasena) >= 8)
);

-- Crear tabla Usuarios
CREATE TABLE Usuarios (
    idUsuario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    correo VARCHAR(255) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    contrasena VARCHAR(255) NOT NULL CHECK (LENGTH(contrasena) >= 8),
    CONSTRAINT pk_usuarios PRIMARY KEY (idUsuario)
);

-- Crear tabla Cursos
CREATE TABLE Cursos (
    idCurso TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    anioAcademico CHAR(9) NOT NULL,  -- Formato '2024/2025'
    fechaInicio DATE NOT NULL,
    fechaFinalizacion DATE NULL,
    CONSTRAINT pk_cursos PRIMARY KEY (idCurso)
);

-- Crear tabla Moderador
CREATE TABLE Moderador (
    idUsuario SMALLINT UNSIGNED NOT NULL,
    fechaAsignacion DATETIME NOT NULL,
    fechaAbandono DATETIME NULL,
    CONSTRAINT pk_moderador PRIMARY KEY (idUsuario),
    CONSTRAINT fk_moderador_usuario FOREIGN KEY (idUsuario) 
        REFERENCES Usuarios(idUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear tabla Solicitudes
CREATE TABLE Solicitudes (
    idUsuario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    numSolicitud CHAR(13) NOT NULL,
    fechaInicioAusencia TIMESTAMP NOT NULL,
    fechaFinAusencia TIMESTAMP NOT NULL,
    motivo VARCHAR(100) NOT NULL, 
    archivoMotivo VARCHAR(255) NULL,
    descripcionMotivo VARCHAR(255) NULL,
    estado BIT NULL,
    idCurso TINYINT UNSIGNED NOT NULL,
    CONSTRAINT pk_solicitudes PRIMARY KEY (idUsuario, numSolicitud, fechaInicioAusencia),
    CONSTRAINT fk_solicitudes_usuario FOREIGN KEY (idUsuario) 
        REFERENCES Usuarios(idUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_solicitudes_curso FOREIGN KEY (idCurso) 
        REFERENCES Cursos(idCurso)
);

-- Crear tabla Trabajo_asignado
CREATE TABLE Trabajo_asignado (
    idUsuario SMALLINT UNSIGNED NOT NULL,
    numSolicitud CHAR(13) NOT NULL,
    fechaAusencia TIMESTAMP NOT NULL,
    hora CHAR NOT NULL,
    nota VARCHAR(255) NULL,
    archivoTarea VARCHAR(255) NULL,
    CONSTRAINT pk_trabajo_asignado PRIMARY KEY (idUsuario, numSolicitud, fechaAusencia, hora),
    CONSTRAINT fk_trabajo_asignado_solicitud FOREIGN KEY (idUsuario, numSolicitud, fechaAusencia) 
        REFERENCES Solicitudes(idUsuario, numSolicitud, fechaInicioAusencia) ON DELETE CASCADE ON UPDATE CASCADE
);

-- INSERT INTOS
-- Inserciones para la tabla Administrador
INSERT INTO Administrador (correo, contrasena) VALUES
('dirsecundaria.guadalupe@fundacionloyola.es', '12345678');  -- Admin principal