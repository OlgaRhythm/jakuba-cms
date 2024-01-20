<?php
// root

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php")) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."load.php");
    start(); // DIR_CORE/index.php
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "install.php");
}


