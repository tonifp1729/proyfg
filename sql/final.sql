-- CREACIÓN DE TABLAS
-- Tabla Roles
CREATE TABLE Roles (
    idRol CHAR(1) NOT NULL,
    nombreRol VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idRol)
);

--Tabla Etapas
CREATE TABLE Etapas (
    idEtapa CHAR(1) NOT NULL,
    nombreEtapa VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idEtapa)
);

--Tabla Usuarios
CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT,
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario),
    FOREIGN KEY (rol) REFERENCES Roles(idRol)
);

--Tabla usuarios_etapas
CREATE TABLE usuarios_etapas (
    idUsuario INT NOT NULL,
    idEtapa CHAR(1) NOT NULL,
    PRIMARY KEY (idUsuario, idEtapa),
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idEtapa) REFERENCES Etapas(idEtapa) ON DELETE CASCADE
);

--Tabla cursos
CREATE TABLE Cursos (
    idCurso INT AUTO_INCREMENT,
    anoAcademico INT NOT NULL,
    fechaInicio DATE NOT NULL,
    fechaFinalizacion DATE NOT NULL,
    PRIMARY KEY (idCurso)
);

--Tabla Motivos
CREATE TABLE Motivos (
    idMotivo INT AUTO_INCREMENT,
    nombreMotivo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (idMotivo)
);

--Tabla Solicitudes
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

--Tabla Archivos
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

--Tabla historico_gestiones
CREATE TABLE historico_gestiones (
    idModerador INT NOT NULL, 
    idSolicitante INT NOT NULL,
    fechaInicioAusencia DATE NOT NULL,
    fechaModeracion DATETIME NOT NULL,
    tipoModeracion VARCHAR(255) NOT NULL,
    PRIMARY KEY (idModerador, idSolicitante, fechaInicioAusencia),
    FOREIGN KEY (idModerador) REFERENCES Usuarios(idUsuario),
    FOREIGN KEY (idSolicitante, fechaInicioAusencia) REFERENCES Solicitudes(idUsuarioSolicitante, fechaInicioAusencia) 
        ON DELETE CASCADE
);

--INSERCIONES INICIALES NECESARIAS
--Inserción para roles
INSERT INTO Roles (idRol, nombreRol, descripcion) VALUES
('A', 'Administrador', 'Usuario con privilegios administrativos'),
('M', 'Moderador', 'Usuario con privilegios de moderación'),
('U', 'Usuario', 'Usuario común del sistema');

--Inserción para etapas
INSERT INTO Etapas (idEtapa, nombreEtapa, descripcion) VALUES
('I', 'Infantil', 'Departamento de educación infantil'),
('P', 'Primaria', 'Departamento de educación primaria'),
('S', 'Secundaria', 'Departamento de educación secundaria'),
('B', 'Bachillerato', 'Departamento de bachillerato'),
('F', 'Formación Profesional', 'Departamento de formación profesional');

--Inserción para usuarios (el administrador)
INSERT INTO Usuarios (correo, nombre, apellidos, rol) VALUES
('dirsecundaria.guadalupe@fundacionloyola.es', 'Director', 'Secundaria', 'A');

--Inserción para las etapas en que trabaja el administrador (puede cambiarlas después)
INSERT INTO usuarios_etapas (idUsuario, idEtapa) VALUES
(1, 'S'),
(1, 'F');