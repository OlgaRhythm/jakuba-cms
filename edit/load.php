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

$directoryModel = $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/model";
$directoryView = $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/view";

$phpFilesModel = getAllPhpFiles($directoryModel);
$phpFilesView = getAllPhpFiles($directoryView);

$phpFiles = array_merge($phpFilesModel, $phpFilesView);

foreach ($phpFiles as $file) {
    require_once($file);
}