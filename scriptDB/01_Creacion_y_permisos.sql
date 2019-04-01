-- Creación de la base de datos si no existe. --
CREATE DATABASE IF NOT EXISTS IGCDBDepartamentos;

-- Creación de la tabla Departamento si no existe. --
CREATE TABLE IF NOT EXISTS Departamento(
    CodDepartamento varchar(256) PRIMARY KEY, 
    DescDepartamento varchar(255) NOT NULL
)Engine=InnoDB;

-- Creación de la tabla Usuario si no existe. --
CREATE TABLE IF NOT EXISTS Usuario(
    CodUsuario varchar(256) PRIMARY KEY,
    DescUsuario varchar(255) NOT NULL,
    Password varchar(256) NOT NULL,
    Perfil enum('Usuario', 'Administrador') NOT NULL
)Engine=InnoDB;

-- Creación del usuario si no existe. --
CREATE USER IF NOT EXISTS 'usuarioDBDepartamentos'@'%' IDENTIFIED BY 'paso';

-- Damos los permisos al usuario creado. --
GRANT ALL PRIVILEGES ON *.* TO 'usuarioDBDepartamentos'@'%';
