<?php
session_start();

// Проверка наличия флага авторизации в сессии
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /edit/a/login.php");
    die();
}
