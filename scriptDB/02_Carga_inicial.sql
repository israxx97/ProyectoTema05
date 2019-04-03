-- Inserción de datos en la tabla Departamento. --
INSERT INTO Departamento (CodDepartamento, DescDepartamento) VALUES
    ('AAA', 'Mi departamento AAA'),
    ('AAB', 'Mi departamento AAB'),
    ('BBB', 'Mi departamento BBB'),
    ('BBC', 'Mi departamento BBC'),
    ('CCC', 'Mi departamento CCC'),
    ('CCD', 'Mi departamento CCD'),
    ('DDD', 'Mi departamento DDD'),
    ('DDE', 'Mi departamento DDE'),
    ('EEE', 'Mi departamento EEE'),
    ('EEF', 'Mi departamento EEF');

-- Inserción de datos en la tabla Usuario. --
INSERT INTO Usuario (CodUsuario, DescUsuario, Password, Perfil, NumVisitas, UltimaVisita) VALUES
    ('admin', 'Administrador', SHA2('adminpaso', 256), 'Administrador', 0, now()),
    ('israel', 'Israel', SHA2('israelpaso', 256), 'Usuario', 0, now()),
    ('christian', 'Christian', SHA2('christianpaso', 256), 'Usuario', 0, now()),
    ('david', 'David', SHA2('davidpaso', 256), 'Usuario', 0, now()),
    ('adrian', 'Adrian', SHA2('adrianpaso', 256), 'Usuario', 0, now()),
    ('tania', 'Tania', SHA2('taniapaso', 256), 'Usuario', 0, now()),
    ('alejandro', 'Alejandro', SHA2('alejantdropaso', 256), 'Usuario', 0, now()),
    ('victor', 'Victor', SHA2('victorpaso', 256), 'Usuario', 0, now()),
    ('mario', 'Mario', SHA2('mariopaso', 256), 'Usuario', 0, now()),
    ('laura', 'Laura', SHA2('laurapaso', 256), 'Usuario', 0, now()),
    ('heraclio', 'Heraclio', SHA2('heracliopaso', 256), 'Usuario', 0, now()),
    ('baldomero', 'Baldomero', SHA2('baldomeropaso', 256), 'Usuario', 0, now()),
    ('amor', 'Amor', SHA2('amorpaso', 256), 'Usuario', 0, now()),
    ('maria', 'Maria', SHA2('mariapaso', 256), 'Usuario', 0, now()),
    ('teresa', 'Teresa', SHA2('teresapaso', 256), 'Usuario', 0, now());