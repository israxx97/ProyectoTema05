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
INSERT INTO Usuario (CodUsuario, DescUsuario, Password, Perfil) VALUES
    (SHA2('admin', 256), 'Administrador', SHA2('paso', 256), 'Administrador'),
    (SHA2('israel', 256), 'Israel', SHA2('paso', 256), 'Usuario'),
    (SHA2('christian', 256), 'Christian', SHA2('paso', 256), 'Usuario'),
    (SHA2('david', 256), 'David', SHA2('paso', 256), 'Usuario'),
    (SHA2('adrian', 256), 'Adrian', SHA2('paso', 256), 'Usuario'),
    (SHA2('tania', 256), 'Tania', SHA2('paso', 256), 'Usuario'),
    (SHA2('alejandro', 256), 'Alejandro', SHA2('paso', 256), 'Usuario'),
    (SHA2('victor', 256), 'Victor', SHA2('paso', 256), 'Usuario'),
    (SHA2('mario', 256), 'Mario', SHA2('paso', 256), 'Usuario'),
    (SHA2('laura', 256), 'Laura', SHA2('paso', 256), 'Usuario'),
    (SHA2('heraclio', 256), 'Heraclio', SHA2('paso', 256), 'Usuario'),
    (SHA2('baldomero', 256), 'Baldomero', SHA2('paso', 256), 'Usuario'),
    (SHA2('amor', 256), 'Amor', SHA2('paso', 256), 'Usuario'),
    (SHA2('maria', 256), 'Maria', SHA2('paso', 256), 'Usuario'),
    (SHA2('teresa', 256), 'Teresa', SHA2('paso', 256), 'Usuario');