<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 02 - Israel García Cabañeros</title>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once '../config/config.php';

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="adminsql"');
            header("HTTP/1.0 401 Unauthorized");
        } else {
            try {
                $miDB = new PDO(HOST_DB, USER_DB, PASS_DB);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $codUsuario = $_SERVER['PHP_AUTH_USER'];
                $codPassHash = hash('sha256', $_SERVER['PHP_AUTH_PW']);
                $statement = $miDB->prepare('SELECT * FROM Usuarios WHERE codUsuario = :codUsuario AND password = :codPassHash');
                $statement->bindParam(':codUsuario', $codUsuario);
                $statement->bindParam(':codPassHash', $codPassHash);
                $statement->execute();

                if ($statement->rowCount() == 0) {
                    header('WWW-Authenticate: Basic realm="Acceso denegado"');
                    header("HTTP/1.0 401 Unauthorized");
                } else {
                    session_start();
                    $_SESSION['username'] = $codUsuario;
                    header('Location: Acceso_Ejercicio_02.php');
                }
            } catch (PDOException $pdoe) {
                echo $pdoe->getMessage();
            } finally {
                unset($miDB);
            }
        }
        ?>
    </body>
</html>