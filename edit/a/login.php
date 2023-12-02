<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
$title = "Вход Admin";
//include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/model/dbEdit.php");

$db = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);

// Проверка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка введенных данных
    if ($db->authentication($_POST["username"], $_POST["password"])) {
        $_SESSION["loggedin"] = true; // Установка флага авторизации в сессии
        header("location: /edit/"); // Перенаправление на защищенную страницу
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}

?>

<html>
<body>
    <form method="post" action="">
        <label for="username">Имя пользователя:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Войти">
    </form>
    <?php if(isset($error)) { echo $error; } ?>
</body>
</html>