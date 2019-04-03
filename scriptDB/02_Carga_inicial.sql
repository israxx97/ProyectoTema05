-- Inserción de datos en la tabla Departamento. --
INSERT INTO Departamentos (codDepartamento, descDepartamento, fechaBaja) VALUES
    ('AAA', 'Mi departamento AAA', NULL),
    ('AAB', 'Mi departamento AAB', NULL),
    ('BBB', 'Mi departamento BBB', NULL),
    ('BBC', 'Mi departamento BBC', NULL),
    ('CCC', 'Mi departamento CCC', NULL),
    ('CCD', 'Mi departamento CCD', NULL),
    ('DDD', 'Mi departamento DDD', NULL),
    ('DDE', 'Mi departamento DDE', NULL),
    ('EEE', 'Mi departamento EEE', NULL),
    ('EEF', 'Mi departamento EEF', NULL);

-- Inserción de datos en la tabla Usuario. --
INSERT INTO Usuarios (codUsuario, descUsuario, password, perfil, numVisitas, fechaHora) VALUES
    ('admin', 'Administrador', SHA2('paso', 256), 'Administrador', 0, NULL),
    ('israel', 'Israel', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('christian', 'Christian', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('david', 'David', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('adrian', 'Adrian', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('tania', 'Tania', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('alejandro', 'Alejandro', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('victor', 'Victor', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('mario', 'Mario', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('laura', 'Laura', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('heraclio', 'Heraclio', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('baldomero', 'Baldomero', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('amor', 'Amor', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('maria', 'Maria', SHA2('paso', 256), 'Usuario', 0, NULL),
    ('teresa', 'Teresa', SHA2('paso', 256), 'Usuario', 0, NULL);