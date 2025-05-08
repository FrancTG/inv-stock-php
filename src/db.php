<?php
    // mysqli('ip_address','db_user','db_password','db_name');
    $mysqli = new mysqli('localhost', 'root', '', 'inv-stock-new');
    if ($mysqli->connect_error) {
        die ("Conexión fallida: " . $mysqli->connect_error);
    }
    elseif(!$mysqli->set_charset("utf8")) {
        die ("Error al establecer el conjunto de caracteres UTF-8:" . $mysqli->error);
    }
?>