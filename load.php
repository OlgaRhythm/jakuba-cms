<?php 
function getAllPhpFiles($dir) {
    $files = [];
    $items = scandir($dir);

    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            $path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                $files = array_merge($files, getAllPhpFiles($path));
            } elseif (pathinfo($path, PATHINFO_EXTENSION) == 'php') {
                $files[] = $path;
            }
        }
    }

    return $files;
}

// Пример использования функции
$directory = $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE;
$phpFiles = getAllPhpFiles($directory);

// Вывод результатов
foreach ($phpFiles as $file) {
    //echo $file . "\n";
    require_once($file);
}
