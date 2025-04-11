<?php
    session_start();
    
    if (!isset($_SESSION["username"])) {
        header("Location: /inv-stock-php/src/login.php");
        exit();
    }
?>