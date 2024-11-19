
CREATE TABLE Roles (
    idRol CHAR(1) NOT NULL,
    nombreRol VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idRol)
);

CREATE TABLE Etapas (
    idEtapa CHAR(1) NOT NULL,
    nombreEtapa VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idEtapa)
);

CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT,
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario),
    FOREIGN KEY (rol) REFERENCES Roles(idRol)
);

CREATE TABLE usuarios_etapas (
    idUsuario INT NOT NULL,
    idEtapa CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario, idEtapa),
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idEtapa) REFERENCES Etapas(idEtapa) ON DELETE CASCADE
);

CREATE TABLE Cursos (
    idCurso INT AUTO_INCREMENT,
    anoAcademico INT NOT NULL,
    fechaInicio DATE NOT NULL,
    fechaFinalizacion DATE NOT NULL,
    PRIMARY KEY (idCurso)
);

CREATE TABLE Motivos (
    idMotivo INT AUTO_INCREMENT,
    nombreMotivo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idMotivo)
);

CREATE TABLE Solicitudes (
    idUsuarioSolicitante INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    fechaFinAusencia DATE NOT NULL,
    horasAusencia INT,
    motivo INT NOT NULL,
    descripcionMotivo TEXT,
    estado BIT NOT NULL,
    idCurso INT NOT NULL,
    PRIMARY KEY (idUsuarioSolicitante, fechaInicioAusencia),
    FOREIGN KEY (idUsuarioSolicitante) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE,
    FOREIGN KEY (motivo) REFERENCES Motivos(idMotivo),
    FOREIGN KEY (idCurso) REFERENCES Cursos(idCurso) ON DELETE CASCADE
);

CREATE TABLE Archivos (
    idArchivo INT AUTO_INCREMENT,
    idUsuarioArchiva INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    nombreArchivo VARCHAR(255) NOT NULL,
    tipoArchivo VARCHAR(10) NOT NULL,
    rutaArchivo VARCHAR(255) NOT NULL,
    PRIMARY KEY (idArchivo),
    FOREIGN KEY (idUsuarioArchiva, fechaInicioAusencia) REFERENCES Solicitudes(idUsuarioSolicitante, fechaInicioAusencia) 
        ON DELETE CASCADE
);

CREATE TABLE historico_gestiones (
    idModerador INT NOT NULL, 
    idSolicitante INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    fechaModeracion DATETIME NOT NULL,
    tipoModeracion VARCHAR(255) NOT NULL,
    PRIMARY KEY (idModerador, idSolicitante, fechaInicioAusencia),
    FOREIGN KEY (idModerador) REFERENCES Usuarios(idUsuario)
);

--CONSULTAS PARA ELIMINAR LAS TABLAS-------------------------------------------------------------------------------------------

DROP TABLE historico_gestiones;
DROP TABLE Archivos;

DROP TABLE Solicitudes;
DROP TABLE usuarios_etapas;

DROP TABLE Motivos;
DROP TABLE Cursos;
DROP TABLE Usuarios;
DROP TABLE Etapas;
DROP TABLE Roles;