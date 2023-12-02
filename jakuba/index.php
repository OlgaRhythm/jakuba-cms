<?php 

/*
* Название: Getting page content from database 
* Получение данных из базы данных и передача в controller (pageView.php)
*/

function start() {
    $pageDB = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);

    $url = prepare_url($_SERVER['REQUEST_URI']);
    
    $arrPageProperties = $pageDB->getPagePropertyByUrl($url);
    
    $arrPageBlocksIds = $pageDB->getPageBlocksByIds(explode(",", $arrPageProperties["blocks"]));

    $page = new pageView($arrPageProperties, $arrPageBlocksIds);

    //print_r($page->getTitle());

    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_TEMPLATES . "/" . DIR_MAINTEMPLATE . "/" . "index.php";
}








//print_r($arrPageBlocksIds );

//die();

// foreach ($arrPageBlocksIds as $blockProperty) {
    //echo "ID: " . $item['id'] . ", Content: " . $item['content'] . ", Path: " . $item['path'] . "<br>";

    //include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php"; 
// }


/*
$viewArr[0] = [
    "ID" => 2,
    "TYPE" => "Text",
    "TYPE_ID" => 2,

    "PATH" => $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php
];

$viewArr[0] = [
    "CONTENT" => 2,
    "PATH" => $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php
];
*/

function prepare_url($url) { // человекопонятный url
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    if ($url) {
        return "/" . $url . "/";
    }
    return "/";
}
