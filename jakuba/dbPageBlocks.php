<?php


require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBPageBlocks extends DB {

    public function getPageIdByUrl($url) {
        return $this->select("Pages", ["id"], ["url" => $url])[0]["id"];
    }

    public function getPageBlocksIdByUrl(string $url) {
        return explode(",", $this->select("Pages", ["blocks"], ["url" => $url])[0]["blocks"]);
    }

    public function getPageBlocksByUrl(string $url) {
        $blocksId = explode(",", $this->select("Pages", ["blocks"], ["url" => $url])[0]["blocks"]);

        $placeholders = str_repeat('?,', count($blocksId) - 1) . '?';

        $sql = "SELECT b.id, b.content, tob.path FROM TypesOfBlocks tob JOIN Blocks b ON b.type = tob.id WHERE b.id IN ($placeholders)";    
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($blocksId);  
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}