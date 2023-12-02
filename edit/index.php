<?php
// admin (edit)
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
$title = "Главная Admin";
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");

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

$directoryModel = $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/model";
$directoryView = $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/view";

$directory = array_merge($directoryModel, $directoryView);

$phpFiles = getAllPhpFiles($directory);

foreach ($phpFiles as $file) {
    require_once($file);
}

//start();
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/footer.php";