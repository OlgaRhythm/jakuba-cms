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
        $sql = "SELECT * FROM Pages";    
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();  
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}