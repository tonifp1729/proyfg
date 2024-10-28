-- Inserciones para la tabla Roles
INSERT INTO Roles (idRol, nombreRol, descripcion) VALUES
('A', 'Administrador', 'Usuario con privilegios administrativos'),
('M', 'Moderador', 'Usuario con privilegios de moderación'),
('U', 'Usuario', 'Usuario común del sistema');

-- Inserciones para la tabla Usuarios
INSERT INTO Usuarios (correo, nombre, apellidos, contrasena, rol) VALUES
('admin@example.com', 'Admin', 'System', 'admin123', 'A'),
('mod1@example.com', 'John', 'Doe', 'mod123', 'M'),
('user1@example.com', 'Jane', 'Smith', 'user123', 'U'),
('user2@example.com', 'Michael', 'Johnson', 'user456', 'U');

-- Inserciones para la tabla Cursos
INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion) VALUES
(2024, '2024-09-01', '2025-06-30'),
(2023, '2023-09-01', '2024-06-30');

-- Inserciones para la tabla Motivos
INSERT INTO Motivos (nombreMotivo, descripcion) VALUES
('Enfermedad', 'Ausencia por motivos de salud'),
('Vacaciones', 'Ausencia por periodo de vacaciones'),
('Otros', 'Otros motivos de ausencia');

-- Inserciones para la tabla Solicitudes
INSERT INTO Solicitudes (idUsuarioSolicitante, fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo, estadom) VALUES
(3, '2024-10-15', '2024-10-20', 40, 1, 'Recuperación de salud', 1),
(4, '2024-11-01', '2024-11-07', 35, 2, 'Vacaciones programadas', 0);

-- Inserciones para la tabla Archivos
INSERT INTO Archivos (idUsuarioArchiva, fechaInicioAusencia, nombreArchivo, tipoArchivo, rutaArchivo) VALUES
(3, '2024-10-15', 'certificado_medico.pdf', 'PDF', '/archivos/certificado_medico.pdf'),
(4, '2024-11-01', 'solicitud_vacaciones.docx', 'DOCX', '/archivos/solicitud_vacaciones.docx');

-- Inserciones para la tabla historico_gestiones
INSERT INTO historico_gestiones (idModerador, idSolicitante, fechaInicioAusencia, fechaModeracion, tipoModeracion) VALUES
(2, 3, '2024-10-15', '2024-10-16 10:00:00', 'Aceptado'),
(2, 4, '2024-11-01', '2024-11-02 15:00:00', 'Aceptado');