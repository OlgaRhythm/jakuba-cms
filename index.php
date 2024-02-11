<?php
// root

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php")) {

    exit();
    // Если конфиг создан, то загружается сайт
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."load.php");
    start(); // DIR_CORE/index.php
} else {
    // Если конфиг ещё не создан, например, при первом запуске, он создаётся
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "install.php");
}


