<?php
    session_start();

    $_SESSION = array();
    session_unset();
    session_destroy();

    header("Location: /inv-stock-php/src/login.php?info=2");
    exit();
?>