<?php
// root (install.php)
require_once($_SERVER['DOCUMENT_ROOT'] . "/jakuba/createConfig.php");
include $_SERVER['DOCUMENT_ROOT'] . "/" . "jakuba" . "/" . "db.php"; // подключение класса db для работы с базой данных
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . "jakuba" . "/creatorDBTables.php");

$dbErrorMsg = "";
if (!test_db_connection()) {
    $dbErrorMsg = "Соединение с базой данных не было установлено! Проверьте корректность данных.";
}

$adminCredentialsErrorMsg = "";
if (!test_admin_credentials()) {
    $adminCredentialsErrorMsg = "Логин и пароль не прошли проверку.";
}

if (!install_cms()) {
    $dbErrorMsg = "Ошибка создания таблиц. Обратитесь к специалисту.";
}

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

                <p>
                    <? echo $dbErrorMsg ?>
                </p>

                <h3>Логин и пароль для администратора</h3>
                <p><label>Логин:<br>
                    <input type="text" name="login" value=""/>
                </label></p>
                
                <p><label>Пароль:<br>
                    <input type="text" name="password" value=""/>
                </label></p>
                <p>
                    <? echo $adminCredentialsErrorMsg ?>
                </p>

                <button>Готово</button>
            </form>
        </body>
        </html>

    <?php
}

/**
 * Создание файла конфигурации, проверка данных на корректность
 * @return false если данные не прошли проверку
 */
function install_cms() {
    if(isset($_POST["name_db"]) && isset($_POST["user_db"]) && isset($_POST["password"]) && isset($_POST["login"])) {
        // подготовка данных для соединения с базой данных
        if (!isset($_POST["password_db"])) $password_db = "";
        else $password_db = $_POST["password_db"];
        if (!isset($_POST["host_db"]) || empty($_POST["host_db"])) $host_db = "localhost";
        else $host_db = $_POST["host_db"];

        if (test_db_connection() && test_admin_credentials()) {
            // создание таблиц в базе данных
            try {
            
                $db = new CreatorDBTables($_POST["name_db"], $_POST["user_db"], $password_db, $host_db);
                $db->createTables($_POST["login"], $_POST["password"]); // создание таблиц
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            } 

            // создание конфига
            create_config($_POST["name_db"], $_POST["user_db"], $password_db, $host_db); 

            // переадресация
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /");
            exit();
        }
    }
    return true;
}

/**
 * Проверка данных для соединения с базой данных
 *  @return false проверка не пройдена 
 * @return true если проверка пройдена или пользователь впервые на странице
 */
function test_db_connection() {
    if (!isset($_POST["name_db"]) && !isset($_POST["user_db"])) return true;

    if (empty($_POST["name_db"]) || empty($_POST["user_db"]) || empty($_POST["password"]) || empty($_POST["login"])) return false;
    
    // обработка данных для соединения с базой данных
    if (!isset($_POST["password_db"])) $password_db = "";
    else $password_db = $_POST["password_db"];
    if (!isset($_POST["host_db"]) || empty($_POST["host_db"])) $host_db = "localhost";
    else $host_db = $_POST["host_db"];

    // тестовая установка соединение с базой данных
    try {
        $testDBConnection = new DB($_POST["name_db"], $_POST["user_db"], $password_db, $host_db);
        return true;       
    } catch (PDOException $e) {
        return false;
    }   
}

/**
 * Проверка логина и пароля администратора
 * @return false если логин и пароль не прошли проверку 
 * @return true если логин и пароль прошли проверку или пользователь впервые на странице
 */
function test_admin_credentials() {
    if (!isset($_POST["password"]) && !isset($_POST["login"])) return true;
    if (empty($_POST["password"]) || empty($_POST["login"])) {
        return false;
    }
    return true;
}
