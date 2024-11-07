
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