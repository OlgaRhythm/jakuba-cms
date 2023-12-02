<?php
session_start();

// Уничтожение всех сессионных данных
session_destroy();

header("location: /edit/a/login.php");
exit;
?>