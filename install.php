<?php
// root

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
            // создание конфига
            // соединение с базой данных
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /");
            exit();
        }
    }
    return false;
}