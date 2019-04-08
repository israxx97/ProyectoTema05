<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_GET['idioma'] != null) {
    switch ($_GET['idioma']) {
        case 'es':
            $_SESSION['idioma'] = $_GET['idioma'];

            break;

        case 'en':
            $_SESSION['idioma'] = $_GET['idioma'];

            break;

        default:
            $_SESSION['idioma'] = 'es';

            break;
    }
} else if (!$_SESSION['idioma']) {
    $_SESSION['idioma'] = 'es';
}

include ($_SESSION['idioma'] . '.php');
