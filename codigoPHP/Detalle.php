<!DOCTYPE html>
<html>
    <head>
        <title>Detalle - Israel García Cabañeros</title>
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="volver" value="Volver a programa"/>
        </form>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require "../config/config.php";
        require "../core/validacionFormularios.php";

        session_start();

        if (!isset($_SESSION['usuarioIGCDepartamento'])) {
            header('Location: ./Programa.php');
        }

        if (isset($_REQUEST['volver'])) {
            header('Location: ./Programa.php');
        }
        ?>
        <h3>$GLOBALS</h3>
        <?php
        echo '<pre>';
        print_r($GLOBALS);
        echo '</pre>';
        ?>
        <h3>$_SERVER</h3>
        <?php
        foreach ($_SERVER as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
        <h3>$_COOKIE</h3>
        <?php
        foreach ($_COOKIE as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
        <h3>$_SESSION</h3>
        <?php
        foreach ($_SESSION as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
    </body>
</html>