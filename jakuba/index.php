<?php 

require_once( $_SERVER['DOCUMENT_ROOT'] . "/config.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/dbPageBlocks.php");


$page = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);

$url = prepare_url($_SERVER['REQUEST_URI']);

$pageId = $page->getPageBlocksByUrl($url);

print_r($pageId);


function prepare_url($url) { // человекопонятный url
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    if ($url) {
        return "/" . $url . "/";
    }
    return "/";
}

