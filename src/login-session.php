<?php

require "db.php";

session_start();

$uname = $_POST["username"];
$pwd = $_POST["password"];

$SQL= "SELECT username, password, name, surnames, rol FROM users WHERE username=?";

$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("s",$uname);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (password_verify($pwd, $row["password"])) {
    $_SESSION["username"] = $row["username"];
    $_SESSION["rol"] = $row["rol"];
    $_SESSION["nameUser"] = $row["name"]." ". $row["surnames"];
    header("Location: /inv-stock-php/src/home.php");
    exit();
} else {
    header("Location: /inv-stock-php/src/login.php?info=1");
    exit();
}
?>