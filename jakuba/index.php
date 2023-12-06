<?php 
//jakuba
/**
 * Получение информации о структуре и наполнении страницы из базы данных и передача в pageView.php для вывода.
 */

function start() {
    $pageDB = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
    $url = prepare_url($_SERVER['REQUEST_URI']);
    $arrPageProperties = $pageDB->getPagePropertyByUrl($url);
    if (!isset($arrPageProperties["id"])){
        include $_SERVER['DOCUMENT_ROOT'] . "/" . "404.php";
        die();
    }
    $arrPageBlocksIds = $pageDB->getPageBlocksByIds(explode(",", $arrPageProperties["blocks"]));

    $page = new pageView($arrPageProperties, $arrPageBlocksIds, $allMetaBlocks);
    $metaBlocks = new pageMetaBlocksView($pageDB);

    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_TEMPLATES . "/" . DIR_MAINTEMPLATE . "/" . "index.php"; // template main: index.php: header.php + getPageBlocks() + footer.php 
}

function prepare_url($url) { // человекопонятный url
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    if ($url) {
        return "/" . $url . "/";
    }
    return "/";
}
