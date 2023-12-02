<?php 

// предназначен для редиректа

// echo $_SERVER['REQUEST_URI'];
echo prepare_url($_SERVER['REQUEST_URI']);

function prepare_url($url) { // человекопонятный url
    $arr_url = array_filter(explode("/", $url), 'strlen');
    $url = implode("/", $arr_url);
    return "/" . $url . "/";
}