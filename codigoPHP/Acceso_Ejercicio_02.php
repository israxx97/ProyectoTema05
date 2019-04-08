<!DOCTYPE html>
<html>
    <head>
        <title>Acceso Ejercicio 02 - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        session_start();

        if (isset($_POST['salir'])) {
            session_destroy();
            header('Location: Ejercicio_02.php');
        }

        if (!isset($_SESSION['username'])) {
            header('Location: Ejercicio_02.php');
        }

        $horaActual = date('H:s:i');

        if (isset($_COOKIE['ultimaVisita'])) {
            $ultimaVisita = $_COOKIE['ultimaVisita'];
        } else {
            setcookie('ultimaVisita', time());
        }

        if (isset($_COOKIE['visitas' . $_SESSION['username']])) {
            setcookie($_COOKIE['visitas' . $_SESSION['username']], $_COOKIE['visitas' . $_SESSION['username']] + 1);
            $mensaje = 'Bienvenido ' . $_SESSION['username'] . ', has visitado esta página ' . $_COOKIE['visitas' . $_SESSION['username']] . ' veces';
        } else {
            setcookie('visitas' . $_SESSION['username'], 1);
        }



        if (isset($_POST['detalle'])) {
            header('Location: Detalle_Ejercicio_02.php');
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <p>
                <?php
                if (isset($ultimaVisita)) {
                    echo 'Última visita: ' . date('d/m/y \a \l\a\s H:i:s', $ultimaVisita) . '<br>';
                } else {
                    $mensaje = 'Bienvenido ' . $_SESSION['username'] . ', esta es tu primera vez en la página.';
                }

                /* echo $mensaje; */
                ?>
            </p>
            <input type="button" name="salir" value="Volver index.php" onclick="location = '../index.php'">
            <input type="submit" name="detalle" value="Detalle">
        </form>
    </body>
</html>