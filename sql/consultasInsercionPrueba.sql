
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

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion) VALUES
(2020, '2023-09-17', '2023-06-20'),
(2021, '2023-09-19', '2023-06-10'),
(2022, '2023-09-16', '2023-06-15'),
(2023, '2023-09-20', '2023-06-12'),
(2024, '2023-09-21', '2023-06-13');

INSERT INTO Motivos (nombreMotivo, descripción) VALUES
('Enfermedad / Baja Médica', 'Permiso relacionado con una enfermedad o baja médica'),
('Problema Familiar', 'Permiso para atender problemas familiares'),
('Visita Médica', 'Ausencia para asistir a una consulta o revisión médica'),
('Cambio de Domicilio', 'Permiso por traslado de vivienda'),
('Día/s sin Sueldo', 'Ausencia autorizada sin remuneración'),
('Formación / Reunión', 'Participación en actividades de formación o reuniones'),
('Experiencias', 'Ausencia por actividades de experiencias personales o profesionales'),
('Actividad Extraescolar / Complementaria', 'Permiso para asistir o participar en actividades extraescolares o complementarias'),
('Baja por Maternidad / Paternidad', 'Ausencia relacionada con el nacimiento o adopción de un hijo/a'),
('Matrimonio', 'Permiso por motivos de matrimonio'),
('Asuntos Propios', 'Permiso para resolver asuntos personales no especificados'),
('Otros', 'Ausencia por un motivo no especificado en las opciones anteriores');

INSERT INTO Solicitudes (fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo) VALUES
('2024-03-01', '2024-03-03', 16, 1, 'Consulta médica especializada'),
('2024-05-10', '2024-05-11', 8, 2, 'Atención a un familiar enfermo'),
('2024-10-15', '2024-10-16', 12, 3, 'Asistencia a un taller de actualización profesional');

INSERT INTO Archivos (idUsuarioArchiva, fechaInicioAusencia, nombreArchvivo, tipoArchivo, rutaArchivo) VALUES
(2, '2024-03-01', 'justificante_medico.pdf', 'PDF', '/archivos/2024/justificante_medico.pdf'),
(4, '2024-10-15', 'certificado_formacion.pdf', 'PDF', '/archivos/2024/certificado_formacion.pdf');

INSERT INTO historico_gestiones (anoAcademico, fechaInicio, fechaFinalizacion) VALUES
(2, 2, '2024-03-01','2024-02-28 09:00:00','Aprobación directa'),
(3, 3, '2024-05-10','2024-05-08 15:30:00','Solicitud en espera'),
(3, 4, '2024-10-15','2024-10-14 11:45:00','Aprobación estándar');

----------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO Usuarios (correo, nombre, apellidos, contrasena, rol) 
VALUES ('tonifp1729@gmail.com', 'SuperAntonio', 'SuperAdmin', SHA2('1234', 256), 'A');