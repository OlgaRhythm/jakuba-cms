<?php

/**
 * Создаёт и заполняет файл config.php
 */
function create_config($name_db, $user_db, $password_db, $host_db) {
    $configFilePath = 'config.php';

    // Создаем содержимое файла
    $configContent = "<?php\n";
    $configContent .= "// Пример файла конфигурации\n\n";
    $configContent .= "define(\"DB_NAME\", \"" . $name_db . "\");\n";
    $configContent .= "define(\"DB_USER\", \"" . $user_db . "\");\n";
    $configContent .= "define(\"DB_PASSWORD\", \"" . $password_db . "\");\n";
    $configContent .= "define(\"DB_HOST\", \"" . $host_db . "\");\n\n";

    $configContent .= "define(\"DIR_CORE\", \"jakuba\");\n";
    $configContent .= "define(\"DIR_ADMIN\", \"edit\");\n";
    $configContent .= "define(\"DIR_ADMIN_TEMPLATE\", \"template\");\n";
    $configContent .= "define(\"DIR_MEDIA\", \"media\");\n";
    $configContent .= "define(\"DIR_MODULES\", \"modules\");\n";
    $configContent .= "define(\"DIR_TEMPLATES\", \"templates\");\n";
    $configContent .= "define(\"DIR_MAINTEMPLATE\", \"main\");\n";

    // Записываем содержимое в файл
    file_put_contents($configFilePath, $configContent);
}

?>