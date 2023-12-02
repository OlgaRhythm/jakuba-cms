<?php 

$page = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);

$url = prepare_url($_SERVER['REQUEST_URI']);

$arrPage = $page->getPageBlocksByUrl($url);

foreach ($arrPage as $blockProperty) {
    //echo "ID: " . $item['id'] . ", Content: " . $item['content'] . ", Path: " . $item['path'] . "<br>";
    
    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php";
}

function prepare_url($url) { // человекопонятный url
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    if ($url) {
        return "/" . $url . "/";
    }
    return "/";
}
