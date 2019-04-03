-- Creación de la base de datos si no existe. --
CREATE DATABASE IF NOT EXISTS IGCDBDepartamentos;

-- Creación de la tabla Departamento si no existe. --
CREATE TABLE IF NOT EXISTS Departamentos (
    codDepartamento varchar(3) PRIMARY KEY, 
    descDepartamento varchar(255) NOT NULL,
    fechaBaja datetime
)Engine=InnoDB;

-- Creación de la tabla Usuario si no existe. --
CREATE TABLE IF NOT EXISTS Usuarios (
    codUsuario varchar(45) PRIMARY KEY,
    descUsuario varchar(255) NOT NULL,
    password varchar(256) NOT NULL,
    perfil enum('usuario', 'administrador') NOT NULL,
    numVisitas int NOT NULL,
    fechaHora datetime
)Engine=InnoDB;

-- Creación del usuario si no existe. --
CREATE USER IF NOT EXISTS 'usuarioIGCDepartamentos'@'%' IDENTIFIED BY 'paso';

-- Damos los permisos al usuario creado. --
GRANT ALL PRIVILEGES ON *.* TO 'usuarioIGCDepartamentos'@'%';
