<!DOCTYPE html>
<html>
    <head>
        <title>Programa - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require "../config/config.php";
        require "../core/validacionFormularios.php";

        session_start();

        if (!isset($_SESSION['usuarioIGCDepartamento'])) {
            header('Location: ./Login.php');
        }

        if (isset($_REQUEST['detalle'])) {
            header('Location: ./Detalle.php');
        }

        if (isset($_REQUEST['salir'])) {
            unset($_SESSION['usuarioIGCDepartamento']);
            session_destroy();
            header('Location: ./Login.php');
        }

        $usuario = $_SESSION['usuarioIGCDepartamento'];

        try {
            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $miDB->prepare('SELECT * FROM Usuarios WHERE codUsuario = :codigo');
            $statement->bindParam(':codigo', $usuario);
            $statement->execute();
            $registroUsuario = $statement->fetchObject();
            $descripcion = $registroUsuario->descUsuario;
            $perfil = $registroUsuario->perfil;
            $numeroVisitas = $registroUsuario->numVisitas;

            if ($numeroVisitas == 1) {
                ?>
                <p>Bienvenid@ <?php echo $descripcion; ?>, esta es tu primera vez en la página.</p>
                <?php
            } else if ($numeroVisitas > 1) {
                ?>
                <p>Hola de nuevo <?php echo $descripcion; ?>, tu número de visitas actual es de <?php echo $numeroVisitas ?>.</p>
                <p>Última conexión: <?php echo $_SESSION['fechaHoraIGCDepartamentos']; ?>.</p>
                <?php
            }
        } catch (PDOException $pdoe) {
            echo $pdoe->getMessage();
        } finally {
            unset($miDB);
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="detalle" value="Detalle"/>
            <input type="submit" name="salir" value="Cerrar Sesión"/>
        </form>
    </body>
</html>