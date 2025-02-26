<?php

require "db.php";

session_start();

$uname = $_POST["username"];
$pwd = $_POST["password"];

$SQL= "SELECT username, password, name, surnames FROM users WHERE username='$uname'";

$res = $mysqli->query($SQL);
$row = $res->fetch_assoc();

if (password_verify($pwd, $row["password"])) {
    $_SESSION["username"] = $row["username"];
    $_SESSION["nameUser"] = $row["name"]." ". $row["surnames"];
    header("Location: home.php");
    exit();
} else {
    header("Location: login.php?info=1");
    exit();
}
?>