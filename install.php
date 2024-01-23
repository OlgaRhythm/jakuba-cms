<?php
// root
require_once($_SERVER['DOCUMENT_ROOT'] . "/jakuba/createConfig.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/jakuba/createDBTables.php");


$isValudate = install_cms();

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php")) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /");
    exit();
} else {
    
    ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Установка</title>
        </head>
        <body>

        <?php
            if ($isValudate === false) {
                //
            }
        ?>

            <form method="POST">
                <h3>Настройка доступа к базе данных</h3>
                <p><label>Адрес базы данных (хост):<br>
                    <input type="text" name="host_db" value="localhost"/>
                </label></p>
                
                <p><label>Имя базы данных:<br>
                    <input type="text" name="name_db" value=""/>
                </label></p>

                <p><label>Имя пользователя базы данных:<br>
                    <input type="text" name="user_db" value=""/>
                </label></p>
                
                <p><label>Пароль базы данных:<br>
                    <input type="text" name="password_db" value=""/>
                </label></p>

                <h3>Логин и пароль для администратора</h3>
                <p><label>Логин:<br>
                    <input type="text" name="login" value=""/>
                </label></p>
                
                <p><label>Пароль:<br>
                    <input type="text" name="password" value=""/>
                </label></p>

                <button>Готово</button>
            </form>
        </body>
        </html>

    <?php
}

function install_cms() {
    if(isset($_POST["name_db"]) && isset($_POST["user_db"]) && isset($_POST["password"]) && isset($_POST["login"])) {
        if (empty($_POST["name_db"]) || empty($_POST["user_db"]) || empty($_POST["password"]) || empty($_POST["login"])) {
            return false;
        } else {
            
            // соединение с базой данных
            // и проверка

            if (!isset($_POST["password_db"])) $password_db = "";
                else $password_db = $_POST["password_db"];
            if (!isset($_POST["host_db"]) || empty($_POST["host_db"])) $host_db = "localhost";
                else $host_db = $_POST["host_db"];
            // создание конфига
            create_config($_POST["name_db"], $_POST["user_db"], $password_db, $host_db);

            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /");
            exit();
        }
    }
    return false;
}