<!DOCTYPE html>
<html>
    <head>
        <title>Cambiar Contraseña - Israel García Cabañeros</title>
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

        $entradaOK = true;

        $a_errores = [
            'password1' => null,
            'password2' => null,
            'password3' => null
        ];

        $a_respuesta = [
            'newPassword' => null,
            'password1' => null,
            'password2' => null,
            'password3' => null
        ];

        try {
            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $codigo = $_SESSION['usuarioIGCDepartamento'];
            $statement = $miDB->prepare('SELECT * FROM Usuarios WHERE codUsuario = :codigo');
            $statement->bindParam(':codigo', $codigo);
            $statement->execute();
            $registros = $statement->fetchObject();
            $oldPassword = $registros->password;

            if (isset($_POST['enviar'])) {
                $a_errores['password1'] = validacionFormularios::comprobarAlfaNumerico($_POST['password1'], 256, 4, 1);
                $a_errores['password2'] = validacionFormularios::comprobarAlfaNumerico($_POST['password2'], 256, 4, 1);
                $a_errores['password3'] = validacionFormularios::comprobarAlfaNumerico($_POST['password3'], 256, 4, 1);

                foreach ($a_errores as $key => $error) {
                    if ($error != null) {
                        $entradaOK = false;
                        $_POST[$key] = '';
                    }
                }

                if ($oldPassword != hash('sha256', $_REQUEST['password1'])) {
                    $a_errores['password1'] = 'Esa no es tu contraseña actual.';
                    $entradaOK = false;
                }

                if (hash('sha256', $_REQUEST['password2']) != hash('sha256', $_REQUEST['password3'])) {
                    $a_errores['password3'] = 'La nueva contraseña debe coincidir en los dos campos.';
                    $entradaOK = false;
                }

                if ($oldPassword == hash('sha256', $_REQUEST['password2'])) {
                    $a_errores['password2'] = 'La nueva contraseña es igual que la actual.';
                    $entradaOK = false;
                }

                if ($oldPassword == hash('sha256', $_REQUEST['password3'])) {
                    $a_errores['password3'] = 'La nueva contraseña es igual que la actual.';
                    $entradaOK = false;
                }
            } else {
                $entradaOK = false;
            }

            if ($entradaOK) {
                $a_respuesta['newPassword'] = hash('sha256', $_REQUEST['password2']);
                $statement = $miDB->prepare('UPDATE Usuarios SET password = :password WHERE codUsuario = :codigo');
                $statement->bindParam(':password', $a_respuesta['newPassword']);
                $statement->bindParam(':codigo', $codigo);
                $statement->execute();
                header('Location: ./Programa.php');
                ?>
                <script type="text/javascript">
                    alert('Contraseña modificada con éxito.');
                </script>
                <?php
            } else {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label for="password1">Contraseña actual:&nbsp;</label>
                    <input type="password" name="password1" id="password1" value="<?php
                    if (isset($_REQUEST['password1']) && is_null($a_errores['password1'])) {
                        echo $_REQUEST['password1'];
                    }
                    ?>"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['password1']; ?></font>
                    <br>
                    <label for="password2">Contraseña nueva:&nbsp;</label>
                    <input type="password" name="password2" id="password2" value="<?php
                    if (isset($_REQUEST['password2']) && is_null($a_errores['password2'])) {
                        echo $_REQUEST['password2'];
                    }
                    ?>"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['password2']; ?></font>
                    <br>
                    <label for="password3">Repetir contraseña nueva:&nbsp;</label>
                    <input type="password" name="password3" id="password3" value="<?php
                    if (isset($_REQUEST['password3']) && is_null($a_errores['password3'])) {
                        echo $_REQUEST['password3'];
                    }
                    ?>"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['password3']; ?></font>
                    <br>
                    <input type="submit" name="enviar" id="enviar" value="Cambiar Contraseña"/>
                    <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="location = './Programa.php'"/>
                </form>
                <?php
            }
        } catch (PDOException $pdoe) {
            $pdoe->getMessage();
        } finally {
            unset($miDB);
        }
        ?>
    </body>
</html>
