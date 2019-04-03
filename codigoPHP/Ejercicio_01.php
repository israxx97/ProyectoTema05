<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 01 - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_POST['salir'])) {
            $_SERVER['PHP_AUTH_USER'] = '';
            $_SERVER['PHP_AUTH_PW'] = '';
            header('Location: ../index.php');
        }

        if ($_SERVER['PHP_AUTH_USER'] != 'admin' || $_SERVER['PHP_AUTH_PW'] != 'paso') {
            header('WWW-Authenticate: Basic Realm="usuarioDBDepartamentos"');
            header('HTTP/1.0 401 Unauthorized');
            echo "Has cancelado la autenticación";
            exit;
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
            <input type="submit" name="salir" value="Salir">
        </form>
        <h3>$_SERVER['PHP_AUTH_USER'];</h3>
        <?php
        echo $_SERVER['PHP_AUTH_USER'];
        ?>
        <h3>$_SERVER['PHP_AUTH_PW'];</h3>
        <?php
        echo $_SERVER['PHP_AUTH_PW'];
        ?>
        <p><font color="red">También pueden verse los valores anteriores más abajo en $_SERVER.</font></p>
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
        <h3>$_GET</h3>
        <?php
        foreach ($_GET as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
        <h3>$_POST</h3>
        <?php
        foreach ($_POST as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
        <h3>$_FILES</h3>
        <?php
        foreach ($_FILES as $key => $value) {
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
        if (isset($_SESSION) && is_null($_SESSION)) {
            foreach ($_SESSION as $key => $value) {
                echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
            }
        }
        ?>
        <h3>$_REQUEST</h3>
        <?php
        foreach ($_REQUEST as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        ?>
        <h3>$_ENV</h3>
        <?php
        foreach ($_ENV as $key => $value) {
            echo '<p><b>' . $key . '</b> = ' . $value . '</p>';
        }
        phpinfo();
        ?>
    </body>
</html>