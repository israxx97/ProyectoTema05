<!DOCTYPE html>
<html>
    <head>
        <title>Editar Perfil - Israel García Cabañeros</title>
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
            'descUsuario' => null
        ];

        $a_respuesta = [
            'descUsuario' => null
        ];

        try {
            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $codigo = $_SESSION['usuarioIGCDepartamento'];
            $statement = $miDB->prepare('SELECT * FROM Usuarios WHERE codUsuario = :codigo');
            $statement->bindParam(':codigo', $codigo);
            $statement->execute();
            $registros = $statement->fetchObject();
            $descUsuario = $registros->descUsuario;
            $perfil = $registros->perfil;

            if (isset($_POST['enviar'])) {
                $a_errores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_POST['descUsuario'], 255, 3, 1);

                foreach ($a_errores as $key => $error) {
                    if ($error != null) {
                        $entradaOK = false;
                        $_POST[$key] = '';
                    }
                }
            } else {
                $entradaOK = false;
            }

            if ($entradaOK) {
                $descripcion = $_REQUEST['descUsuario'];
                $statement = $miDB->prepare('UPDATE Usuarios SET descUsuario = :descripcion WHERE codUsuario = :codigo');
                $statement->bindParam(':descripcion', $descripcion);
                $statement->bindParam(':codigo', $codigo);
                $statement->execute();
                ?>
                <script type="text/javascript">
                    alert('Descripción modificada correctamente.');
                </script>
                <?php
                header('Location: ./Programa.php');
            } else {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label for="codUsuario">Código:&nbsp;</label>
                    <input type="text" name="codUsuario" id="codUsuario" value="<?php echo $_SESSION['usuarioIGCDepartamento']; ?>" disabled/>
                    <br>
                    <label for="descUsuario">Descripción:&nbsp;</label>
                    <input type="text" name="descUsuario" id="descUsuario" value="<?php
                    if (isset($_REQUEST['descUsuario']) && is_null($a_errores['descUsuario'])) {
                        echo $_REQUEST['descUsuario'];
                    } else {
                        echo $descUsuario;
                    }
                    ?>"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['descUsuario']; ?></font>
                    <br>
                    <label for="perfil">Perfil:&nbsp;</label>
                    <input type="text" name="perfil" id="perfil" value="<?php echo $perfil ?>" disabled/>
                    <br>
                    <input type="submit" name="enviar" id="enviar" value="Enviar"/>
                    <input type="button" name="cambiar" id="cambiar" value="Cambiar Password" onclick="location = './CambiarPassword.php'"/>
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
