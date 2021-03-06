<!DOCTYPE html>
<html>
    <head>
        <title>Login - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        require_once './lang.php';
        if (!$_SESSION['idioma']) {
            $_SESSION['idioma'] = 'es';
        }
        ?>
        <nav>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?idioma=' . $_GET['idioma']; ?>" method="POST">
                <label for="espanol"><img src="../webroot/images/spain.png" alt="bandera" style="width: 25px; height: 20px;"></label>
                <input style="display: none; margin: 0;" type="radio" name="idioma" id="espanol" <?php
                if (isset($_REQUEST['idioma']) && ($_REQUEST['idioma'] == 'espanol')) {

                    echo 'checked';
                } else {
                    echo '';
                }
                ?> value="espanol" onclick="location = '?idioma=es'">

                <label for="ingles"><img src="../webroot/images/granbretana.jpg" alt="bandera" style="width: 25px; height: 20px;"></label>
                <input style="display: none; margin: 0;" type="radio" name="idioma" id="ingles" <?php
                if (isset($_REQUEST['idioma']) && ($_REQUEST['idioma'] == 'ingles')) {
                    echo 'checked';
                } else {
                    echo '';
                }
                ?> value="ingles" onclick="location = '?idioma=en'">
            </form>
        </nav>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require "../config/config.php";
        require "../core/validacionFormularios.php";

        setlocale(LC_TIME, 'es_ES.UTF-8');
        date_default_timezone_set('Europe/Madrid');

        $entradaOK = true;

        $a_errores = [
            "usuario" => NULL,
            "password" => NULL,
            'noExiste' => NULL
        ];


        $a_respuesta = [
            "usuario" => NULL,
            "password" => NULL
        ];

        $miDB = null;
        $statement = null;
        $sql = null;
        $numeroRegistros = NULL;

        try {

            $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_REQUEST["entrar"])) {
                $a_errores["usuario"] = validacionFormularios::comprobarAlfabetico($_REQUEST["usuario"], 50, 3, 1);
                $a_errores["password"] = validacionFormularios::comprobarAlfanumerico($_REQUEST["password"], 50, 4, 1);

                $password = hash("sha256", $_REQUEST["password"]);
                $sql = "select * from Usuarios where codUsuario=:usuario and password=:password";
                $statement = $miDB->prepare($sql);

                $statement->bindParam(":usuario", $_REQUEST["usuario"]);
                $statement->bindParam(":password", $password);

                $statement->execute();
                $numeroRegistros = $statement->rowCount();

                if ($numeroRegistros == 0) {
                    $a_errores["noExiste"] = " El usuario no existe. ";
                    $entradaOK = false;
                }

                foreach ($a_errores as $campo => $error) {
                    if ($error != null) {
                        $entradaOK = false;
                        $_REQUEST[$campo] = "";
                    }
                }
            } else {
                $entradaOK = false;
            }

            if ($entradaOK) {
                session_start();


                $_SESSION["usuarioIGCDepartamento"] = $_REQUEST["usuario"];

                $fechaHoraActual = date('Y:m:d H:i:s', time());
                $ultimaFechaHora = NULL;

                $sql = "select * from Usuarios where codUsuario=:usuario";
                $statement = $miDB->prepare($sql);

                $statement->bindParam(":usuario", $_REQUEST["usuario"]);

                $statement->execute();
                $registroUsuario = $statement->fetchObject();
                $numeroVisitas = $registroUsuario->numVisitas;

                if (is_null($registroUsuario->fechaHora)) {
                    $ultimaFechaHora = date("H:i:s d-m-Y", time());
                } else {
                    $ultimaFechaHora = date("H:i:s d-m-Y", strtotime($registroUsuario->fechaHora));
                }

                $_SESSION["fechaHoraIGCDepartamentos"] = $ultimaFechaHora;

                $sql = "update Usuarios set numVisitas=numVisitas+1, fechaHora=:fechaHora where codUsuario=:usuario";
                $statement = $miDB->prepare($sql);

                $statement->bindParam(":fechaHora", $fechaHoraActual);
                $statement->bindParam(":usuario", $_REQUEST["usuario"]);

                $statement->execute();

                header('Location: ./Programa.php');
            } else {
                ?> 

                <h2><?php echo $iniSes; ?></h2> 
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST"> 
                    <label for="usuario"><?php echo $cod; ?>:&nbsp;</label> 
                    <input type="text" id="usuario" name="usuario" value="<?php
                    if (isset($_REQUEST['usuario']) && is_null($a_errores['usuario'])) {
                        echo $_REQUEST['usuario'];
                    }
                    ?>" placeholder="usuario"><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores["usuario"] ?></font>
                    <br> 
                    <label for="password"><?php echo $pass; ?>:&nbsp;</label> 
                    <input type="password" id="password" name="password" value="<?php
                    if (isset($_REQUEST['password']) && is_null($a_errores['password'])) {
                        echo $_REQUEST['password'];
                    }
                    ?>" placeholder="password"><font color="red">&nbsp;*</font>
                    <font color="red"><?php echo $a_errores["password"] ?></font>
                    <br>
                    <font color="red"><?php echo $a_errores["noExiste"] ?></font>
                    <br>
                    <input type="submit" id="entrar" name="entrar" onclick="location = '?idioma=<?php echo $_SESSION['idioma'] ?>'" value="<?php echo $entrar ?>"> 
                    <input type="button" id="registro" name="registrar" value="<?php echo $reg ?>" onclick="location = 'Registro.php'">
                    <input type="button" id="cancelar" name="cancelar" value="<?php echo $cancelar ?>" onclick="location = '../index.php'"> 
                </form> 

                <?php
            }
        } catch (PDOException $pdoe) {
            echo $pdoe->getMessage();
        } finally {
            unset($miDB);
        }
        ?>

    </body>
</html>