<?php
// admin (edit) Передвинуть блок на странице
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Передвинуть блок";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$pageId = 0;

if ((!isset($_GET["pageId"]) || !is_numeric($_GET["pageId"])) || (!isset($_GET["blockId"]) || !is_numeric($_GET["blockId"])) || (!isset($_GET["direction"]) || !is_numeric($_GET["direction"]))) {
    header("location: /edit");
    exit();
}

$pageId = intval($_GET["pageId"]);
$blockId = intval($_GET["blockId"]);
$direction = intval($_GET["direction"]);

$arrPageBlockIds = $dbPages->getPageBlocksIdByPageId($pageId);
$blockIdxInArray = array_search($blockId, $arrPageBlockIds);
//print_r($arrPageBlockIds);
if ($blockIdxInArray !== false) {
    switch ($direction) {
        case -1:
            swap($arrPageBlockIds, $blockIdxInArray, $blockIdxInArray + 1);
            break;
        case 1:
            swap($arrPageBlockIds, $blockIdxInArray, $blockIdxInArray - 1);
            break;
        default:
            header("location: /edit/editPage.php?id=" . $pageId);
            exit();
    }
    //print_r($arrPageBlockIds);
   // die();
    $dbPages->updatePageBlocksById($pageId, implode(",", $arrPageBlockIds));
}

header("location: /edit/editPage.php?id=" . $pageId);
exit();

function swap(&$array, $index1, $index2)
{
    $arrayLength = count($array);

    if ($index1 < 0 || $index1 >= $arrayLength || $index2 < 0 || $index2 >= $arrayLength) {
        return;
    }
    $temp = $array[$index1];
    $array[$index1] = $array[$index2];
    $array[$index2] = $temp;
}
