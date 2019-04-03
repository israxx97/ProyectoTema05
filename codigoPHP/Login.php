<!DOCTYPE html>
<html>
    <head>
        <title>Login - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        require_once '../config/config.php';
        require_once '../core/validacionFormularios.php';

        $entradaOK = true;

        $a_errores = [
            'codUsuario' => null,
            'password' => null
        ];

        $a_respuesta = [
            'codUsuario' => null,
            'password' => null
        ];

        try {
            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            switch (true) {
                case (isset($_POST['entrar'])):
                    $a_errores['codUsuario'] = validacionFormularios::comprobarAlfabetico($_POST['codUsuario'], 256, 3, 1);
                    $a_errores['password'] = validacionFormularios::comprobarAlfaNumerico($_POST['password'], 256, 4, 1);

                    $codUsuario = $_REQUEST['codUsuario'];
                    $pass = hash('sha256', $codUsuario . $_REQUEST['password']);
                    $statement = $miDB->prepare('SELECT * FROM Usuario WHERE CodUsuario = :codUsuario AND Password = :pass');
                    $statement->bindParam(':codUsuario', $codUsuario);
                    $statement->bindParam(':pass', $pass);
                    $statement->execute();

                    if ($statement->rowCount() == 0) {
                        $a_errores['codUsuario'] = $a_errores['codUsuario'] . 'Usuario o contraseña no disponibles.';
                        $entradaOK = false;
                    }

                    foreach ($a_errores as $key => $error) {
                        if ($error != null) {
                            $entradaOK = false;
                        }
                    }

                    break;

                default:
                    $entradaOK = false;

                    break;
            }

            switch (true) {
                case $entradaOK:
                    session_start();
                    $a_respuesta['codUsuario'] = $_REQUEST['codUsuario'];
                    $_SESSION['username'] = $a_respuesta['codUsuario'];
                    $statement = $miDB->prepare('SELECT * FROM Usuario WHERE CodUsuario = :codUsuario');
                    $statement->bindParam(':codUsuario', $a_respuesta['codUsuario']);
                    $statement->execute();
                    $usuario = $statement->fetchObject();
                    $numVisitas = $usuario->NumVisitas;
                    $ultimaVisita = $usuario->UltimaVisita;
                    $_SESSION['numVisitas'] = $numVisitas;
                    $_SESSION['ultimaVisita'] = $ultimaVisita;
                    $statement = $miDB->prepare('UPDATE Usuario SET NumVisitas = NumVisitas + 1, UltimaVisita = :ultimaVisita WHERE CodUsuario = :codigo');
                    $fecha = new DateTime();
                    $fechaActual = $fecha->getTimestamp();
                    $statement->bindParam(':ultimaVisita', $fechaActual);
                    $statement->bindParam(':codigo', $a_respuesta['codUsuario']);
                    $statement->execute();
                    header('Location: Programa.php');

                    break;

                default:
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <label for="codUsuario">Código usuario:&nbsp;</label>
                        <input type="text" name="codUsuario" id="codUsuario" value="<?php
                        if (isset($_REQUEST['codUsuario']) && is_null($a_errores['codUsuario'])) {
                            echo $_REQUEST['codUsuario'];
                        }
                        ?>"/><font color="red">&nbsp;*</font>
                        <font color="red"><?php echo $a_errores['codUsuario']; ?></font>
                        <br>
                        <label for="password">Contraseña:&nbsp;</label>
                        <input type="password" name="password" id="password" value="<?php
                               if (isset($_REQUEST['password']) && is_null($a_errores['password'])) {
                                   echo $_REQUEST['password'];
                               }
                               ?>"/><font color="red">&nbsp;*</font>
                        <font color="red"><?php echo $a_errores['password']; ?></font>
                        <br>
                        <input type="submit" name="entrar" value="Entrar"/>
                        <input type="button" name="cancelar" value="Cancelar" onclick="location = '../index.php'"/>
                    </form>
                    <?php
                    break;
            }
        } catch (PDOException $pdoe) {
            $pdoe->getMessage();
        } finally {
            unset($miDB);
        }
        ?>
    </body>
</html>
