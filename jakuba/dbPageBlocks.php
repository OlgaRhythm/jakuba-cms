<?php


require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBPageBlocks extends DB {

    public function getPageIdByUrl($url) {
        return $this->select("Pages", ["id"], ["url" => $url])[0]["id"];
    }

    public function getPageBlocksIdByUrl(string $url) {
        return explode(",", $this->select("Pages", ["blocks"], ["url" => $url])[0]["blocks"]);
    }

    public function getPageBlocksIdByPageId($id) {
        $arrBlocks = $this->select("Pages", ["blocks"], ["id" => $id])[0]["blocks"];
        if ($arrBlocks) {
            return explode(",",  $arrBlocks);
        } 
        return [];
    }

    public function getPagePropertyByUrl(string $url) {
        return $this->select("Pages", ["*"], ["url" => $url])[0];
    }

    public function getPagePropertyByPageId($id) {
        return $this->select("Pages", ["*"], ["id" => $id])[0];
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

    
    public function getPageBlocksByIds(array $arrayIds) {
        if (count($arrayIds) < 1) {
            return [];
        } 
        $placeholders = str_repeat('?,', count($arrayIds) - 1) . '?';

        $sql = "SELECT b.id, b.content, tob.path, tob.id AS type_id, tob.type AS type_name FROM TypesOfBlocks tob JOIN Blocks b ON b.type = tob.id WHERE b.id IN ($placeholders)";    
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrayIds);  
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $arrBlocksInOrder = [];

        foreach($arrayIds as $id) {
            foreach($res as $block) {
                if ($block["id"] == $id) {
                    $arrBlocksInOrder[] = $block;
                }
            }
        }
        return $arrBlocksInOrder;
    }

}