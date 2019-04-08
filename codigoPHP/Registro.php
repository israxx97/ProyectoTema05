<!DOCTYPE html>
<html>
    <head>
        <title>Registro - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once '../config/config.php';
        require_once '../core/validacionFormularios.php';

        $entradaOK = true;

        $a_errores = [
            'codUsuario' => null,
            'descUsuario' => null,
            'password' => null
        ];

        $a_respuesta = [
            'codUsuario' => null,
            'descUsuario' => null,
            'password' => null
        ];

        try {
            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_POST['entrar'])) {
                $a_errores['codUsuario'] = validacionFormularios::comprobarAlfabetico($_POST['codUsuario'], 100, 3, 1);
                $a_errores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_POST['descUsuario'], 255, 3, 1);
                $a_errores['password'] = validacionFormularios::comprobarAlfaNumerico($_POST['password'], 45, 4, 1);

                $codigo = $_REQUEST['codUsuario'];
                $statement = $miDB->prepare('SELECT * FROM Usuarios WHERE codUsuario = :codigo');
                $statement->bindParam(':codigo', $codigo);
                $statement->execute();

                if ($statement->rowCount() != 0) {
                    $a_errores['codUsuario'] = "Usuario con código " . $_REQUEST['codUsuario'] . " ya existente.";
                }

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
                $codigo = $_REQUEST['codUsuario'];
                $descripcion = $_REQUEST['descUsuario'];
                $password = hash('sha256', $_REQUEST['password']);
                $statement = $miDB->prepare('INSERT INTO Usuarios (codUsuario, descUsuario, fechaHora, numVisitas, password, perfil) VALUES (:codigo, :descripcion, now(), 1, :password, "usuario")');
                $statement->bindParam(':codigo', $codigo);
                $statement->bindParam(':descripcion', $descripcion);
                $statement->bindParam(':password', $password);
                $statement->execute();
                session_start();
                $_SESSION['usuarioIGCDepartamento'] = $_POST['codUsuario'];
                ?>
                <script type="text/javascript">
                    alert('Usuario registrado correctamente.');
                </script>
                <?php
                header('Location: ./Programa.php');
            } else {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <label for="codUsuario">Código:&nbsp;</label>
                    <input type="text" name="codUsuario" id="codUsuario" value="<?php
                    if (isset($_REQUEST['codUsuario']) && is_null($a_errores['codUsuario'])) {
                        echo $_REQUEST['codUsuario'];
                    }
                    ?>" placeholder="Código"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['codUsuario']; ?></font>
                    <br>
                    <label for="descUsuario">Descripción:&nbsp;</label>
                    <input type="text" name="descUsuario" id="descUsuario" value="<?php
                    if (isset($_REQUEST['descUsuario']) && is_null($a_errores['descUsuario'])) {
                        echo $_REQUEST['descUsuario'];
                    }
                    ?>" placeholder="Descripción"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['descUsuario']; ?></font>
                    <br>
                    <label for="password">Contraseña:&nbsp;</label>
                    <input type="password" name="password" id="password" value="<?php
                    if (isset($_REQUEST['password']) && is_null($a_errores['password'])) {
                        echo $_REQUEST['password'];
                    }
                    ?>" placeholder="Contraseña"/><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores['password']; ?></font>
                    <br>
                    <input type="submit" name="entrar" value="Registro"/>
                    <input type="button" name="cancelar" id="cancelar" value="Cancelar"/>
                </form>
                <?php
            }
        } catch (PDOException $pdoe) {
            $pdoe->getMessage();
        } finally {
            unset($miDB);
        }
        ?>
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script type="text/javascript">
                    $('#cancelar').on('click', function () {
                        /* if ($('#codUsuario').value != "") || ($('#descUsuario').value != "") || ($('#password').value != "")) {
                         if (confirm('Si sales ahora, los valores de los campos no se guardarán. ¿Estas seguro?')) {
                         window.location.href = './Login.php';
                         }
                         } else {
                         */ window.location.href = './Login.php'; /*
                          } */
                    });
        </script>
    </body>
</html>