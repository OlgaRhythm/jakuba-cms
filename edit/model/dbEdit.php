<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBEdit extends DB {

    public function authentication($login, $password) {
        $passhash = md5($password);
        if (isset($this->select("Users", ["id"], ["login" => $login, "password" => $passhash])[0]["id"])) {
            return true;
        }
    }
    
    public function getCountPages() {
        $sql = "SELECT COUNT(*) AS count_pages FROM Pages"; 
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();  
        return $stmt->fetchColumn();
    }

    public function getAllPages() {
        return $this->select("Pages", ["*"]);
    }

    public function checkUnicUrlPage (string $url) {
        $condition = ["url" => $url];
        if (count($this->select("Pages", ["id"], $condition)) >= 1) return false;
        return true;
    }

    public function createPage($title, $url) {
        $pageProperties = ["title" => $title, "url" => $url];
        return $this->insert("Pages", $pageProperties);
    }

    public function getAllBlockTypes() {
        return $this->select("TypesOfBlocks", ["*"]);
    }

}