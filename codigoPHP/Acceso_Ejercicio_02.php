<?php

if (isset($_SESSION) && is_null($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        echo $key . ' = ' . $value;
    }
}