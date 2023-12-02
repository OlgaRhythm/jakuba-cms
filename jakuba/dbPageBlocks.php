<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBPageBlocks extends DB {

    public function getPageIdByUrl($url) {
        return $this->select("Pages", ["id"], ["url" => $url])[0]["id"];
    }

    /*
    *  
    * return array из id блоков
    */
    public function getPageBlocksByUrl(string $url) {
        return explode(",", $this->select("Pages", ["blocks"], ["url" => $url])[0]["blocks"]);
    }

}