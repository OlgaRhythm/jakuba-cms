<?php
// admin (edit) Удаление существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Удаление страницы";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$blockTypeId = 0;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: /edit");
    exit();
}

$dbPages->deletePageById(intval($_GET["id"]));

header("location: /edit");
exit();
