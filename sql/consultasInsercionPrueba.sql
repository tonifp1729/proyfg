-- Inserción de cursos pasados
INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2020/2021', '2020-09-01', '2021-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2021/2022', '2021-09-01', '2022-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2022/2023', '2022-09-01', '2023-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2019/2020', '2019-09-01', '2020-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2018/2019', '2018-09-01', '2019-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2017/2018', '2017-09-01', '2018-06-30');

INSERT INTO Cursos (anoAcademico, fechaInicio, fechaFinalizacion)
VALUES ('2016/2017', '2016-09-01', '2017-06-30');

-- Insertar usuarios comunes
INSERT INTO Usuarios (correo, nombre, apellidos, contrasena, rol) 
VALUES ('ana.garcia@fundacionloyola.es', 'Ana', 'García', SHA2('mi_contrasena_ana', 256), 'U'),
       ('luis.martinez@fundacionloyola.es', 'Luis', 'Martínez', SHA2('mi_contrasena_luis', 256), 'U'),
       ('marta.sanchez@fundacionloyola.es', 'Marta', 'Sánchez', SHA2('mi_contrasena_marta', 256), 'U');

-- Solicitudes de Ana García (Correo: ana.garcia@fundacionloyola.es)
INSERT INTO Solicitudes (idUsuarioSolicitante, fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo, estado, idCurso)
VALUES (2, '2020-12-01', '2020-12-05', 40, 1, 'Enfermedad', 1, 1),
       (2, '2021-02-10', '2021-02-15', 30, 2, 'Vacaciones de Navidad', 0, 2);

-- Solicitudes de Luis Martínez (Correo: luis.martinez@fundacionloyola.es)
INSERT INTO Solicitudes (idUsuarioSolicitante, fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo, estado, idCurso)
VALUES (3, '2021-10-01', '2021-10-10', 50, 3, 'Formación Profesional', 1, 2),
       (3, '2022-03-01', '2022-03-03', 24, 1, 'Enfermedad', 0, 3);

-- Solicitudes de Marta Sánchez (Correo: marta.sanchez@fundacionloyola.es)
INSERT INTO Solicitudes (idUsuarioSolicitante, fechaInicioAusencia, fechaFinAusencia, horasAusencia, motivo, descripcionMotivo, estado, idCurso)
VALUES (4, '2019-11-01', '2019-11-10', 40, 2, 'Vacaciones de Navidad', 0, 4),
       (4, '2020-05-05', '2020-05-10', 40, 1, 'Enfermedad', 1, 1); 