-- CREACIÓN DE TABLAS
-- Tabla Roles
CREATE TABLE Roles (
    idRol CHAR(1) NOT NULL,
    nombreRol VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idRol)
);

--Tabla Departamentos
CREATE TABLE Departamentos (
    idDepartamento CHAR(1) NOT NULL,
    nombreDepartamento VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idDepartamento)
);

-- Tabla Usuarios
CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT,
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario),
    FOREIGN KEY (rol) REFERENCES Roles(idRol)
);

-- Tabla usuarios_departamentos
CREATE TABLE usuarios_departamentos (
    idUsuario INT NOT NULL,
    idDepartamento CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario, idDepartamento),
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario),
    FOREIGN KEY (idDepartamento) REFERENCES Departamentos(idDepartamento)
);

-- Tabla Cursos
CREATE TABLE Cursos (
    idCurso INT AUTO_INCREMENT,
    anoAcademico INT NOT NULL,
    fechaInicio DATE NOT NULL,
    fechaFinalizacion DATE NOT NULL,
    PRIMARY KEY (idCurso)
);

-- Tabla Motivos
CREATE TABLE Motivos (
    idMotivo INT AUTO_INCREMENT,
    nombreMotivo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idMotivo)
);

-- Tabla Solicitudes
CREATE TABLE Solicitudes (
    idUsuarioSolicitante INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    fechaFinAusencia DATE NOT NULL,
    horasAusencia INT,
    motivo INT NOT NULL,
    descripcionMotivo TEXT,
    estado BIT NOT NULL,
    PRIMARY KEY (idUsuarioSolicitante, fechaInicioAusencia),
    FOREIGN KEY (idUsuarioSolicitante) REFERENCES Usuarios(idUsuario),
    FOREIGN KEY (motivo) REFERENCES Motivos(idMotivo)
);

-- Tabla Archivos
CREATE TABLE Archivos (
    idArchivo INT AUTO_INCREMENT,
    idUsuarioArchiva INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    nombreArchivo VARCHAR(255) NOT NULL,
    tipoArchivo VARCHAR(10) NOT NULL,
    rutaArchivo VARCHAR(255) NOT NULL,
    PRIMARY KEY (idArchivo),
    FOREIGN KEY (idUsuarioArchiva, fechaInicioAusencia) REFERENCES Solicitudes(idUsuarioSolicitante, fechaInicioAusencia)
);

-- Tabla historicos_gestiones
CREATE TABLE historico_gestiones (
    idModerador INT NOT NULL, 
    idSolicitante INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    fechaModeracion DATETIME NOT NULL,
    tipoModeracion VARCHAR(255) NOT NULL,
    PRIMARY KEY (idModerador, idSolicitante, fechaInicioAusencia),
    FOREIGN KEY (idModerador) REFERENCES Usuarios(idUsuario),
    FOREIGN KEY (idSolicitante, fechaInicioAusencia) REFERENCES Solicitudes(idUsuarioSolicitante, fechaInicioAusencia)
);