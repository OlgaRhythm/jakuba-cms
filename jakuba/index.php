<?php 
//jakuba (DIR_CORE/index.php)
/**
 * Получение информации о структуре и наполнении страницы из базы данных и передача в pageView.php для вывода.
 */
function start() {
    $pageDB = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
    $url = prepare_url($_SERVER['REQUEST_URI']); // получение uri текущей страницы
    $arrPageProperties = $pageDB->getPagePropertyByUrl($url); // получение информации о текущей страницы
    if (!isset($arrPageProperties["id"])){ // если страница в базе не найдена
        include $_SERVER['DOCUMENT_ROOT'] . "/" . "404.php"; // переадресация на страницу 404
        die();
    }
    $arrPageBlocksIds = $pageDB->getPageBlocksByIds(explode(",", $arrPageProperties["blocks"])); // получение содержимого текущей страницы

    $page = new pageView($arrPageProperties, $arrPageBlocksIds, $allMetaBlocks);
    $metaBlocks = new pageMetaBlocksView($pageDB);

    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_TEMPLATES . "/" . DIR_MAINTEMPLATE . "/" . "index.php"; // template main: index.php: header.php + getPageBlocks() + footer.php 
}

/**
 * Преобразует строку в формат url
 */
function prepare_url($url) {
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    if ($url) {
        return "/" . $url . "/";
    }
    return "/";
}
