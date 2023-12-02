<?php
/*
* Внешний вид страницы с кодом 404 (страница не найдена) 
*/
http_response_code(404);
header("Status: 404 Not Found");

require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."load.php");
$arrPageProperties = ["title" => "Страница не найдена"];
$arrPageBlocksIds = [];
$page = new pageView($arrPageProperties, $arrPageBlocksIds);
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_TEMPLATES . "/" . DIR_MAINTEMPLATE . "/" . "header.php";
?>

<div>
    <h1>Error 404</h1>
    <p>Page Not Found</p>
</div>

<?
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_TEMPLATES . "/" . DIR_MAINTEMPLATE . "/" . "footer.php";
