<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBEdit extends DB
{

    public function authentication($login, $password)
    {
        $passhash = md5($password);
        if (isset($this->select("Users", ["id"], ["login" => $login, "password" => $passhash])[0]["id"])) {
            return true;
        }
    }

    public function getCountPages()
    {
        $sql = "SELECT COUNT(*) AS count_pages FROM Pages";
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllPages()
    {
        return $this->select("Pages", ["*"]);
    }

    public function getAllBlocks()
    {
        return $this->select("TypesOfBlocks", ["*"]);
    }

    public function getAllMetaBlocks()
    {
        return $this->select("MetaBlocks", ["*"]);
    }

    public function checkUnicUrlPage(string $url)
    {
        $condition = ["url" => $url];
        if (count($this->select("Pages", ["id"], $condition)) >= 1) return false;
        return true;
    }

    public function checkUnicTypeBlock(string $type)
    {
        $condition = ["type" => $type];
        if (count($this->select("TypesOfBlocks", ["id"], $condition)) >= 1) return false;
        return true;
    }

    public function createPage($title, $url)
    {
        $pageProperties = ["title" => $title, "url" => $url];
        return $this->insert("Pages", $pageProperties);
    }

    public function getAllBlockTypes()
    {
        return $this->select("TypesOfBlocks", ["*"]);
    }

    public function updateContentBlockById($id, string $content)
    {
        return $this->update("Blocks", ["content" => $content], ["id" => $id]);
    }
    public function updatePageTitleUrlById($id, $title, $url)
    {
        return $this->update("Pages", ["url" => $url, "title" => $title], ["id" => $id]);
    }

    public function updatePageBlocksById($id, $blocks)
    {
        return $this->update("Pages", ["blocks" => $blocks], ["id" => $id]);
    }

    public function getPageUrlById($id)
    {
        return $this->select("Pages", ["url"], ["id" => $id])[0]["url"];
    }

    public function getPageBlocksIdByPageId($id)
    {
        $arrBlocks = $this->select("Pages", ["blocks"], ["id" => $id])[0]["blocks"];
        if ($arrBlocks) {
            return explode(",",  $arrBlocks);
        }
        return [];
    }

    public function createNewBlock($type)
    {
        return $this->insert("Blocks", ["type" => $type]);
    }

    public function deleteBlockById($id)
    {
        return $this->delete("Blocks", ["id" => $id]);
    }

    public function createTypeOfBlock(array $blockTypeProperties)
    {
        return $this->insert("TypesOfBlocks", $blockTypeProperties);
    }

    public function createMetaBlock(array $blockTypeProperties)
    {
        return $this->insert("MetaBlocks", $blockTypeProperties);
    }

    public function updateTypeOfBlock($id, array $blockProperties)
    {
        return $this->update("TypesOfBlocks", $blockProperties, ["id" => $id]);
    }

    public function updateMetaBlock($id, array $blockProperties)
    {
        return $this->update("MetaBlocks", $blockProperties, ["id" => $id]);
    }

    public function getTypeOfBlockPropertiesById($id)
    {
        return $this->select("TypesOfBlocks", ["*"], ["id" => $id])[0];
    }

    
    public function getMetaBlockPropertiesById($id)
    {
        return $this->select("MetaBlocks", ["*"], ["id" => $id])[0];
    }

    public function deleteTypeOfBlockById($typeBlockId)
    {
        $arrBlocks = $this->select("Blocks", ["id"], ["type" => $typeBlockId]);
        $arrPages = $this->select("Pages", ["id", "blocks"]);
        foreach ($arrPages as $page) {
            $arrPageBlocksId = explode(",", $page["blocks"]);
            foreach ($arrBlocks as $blockToDeleteId) {
                $idx = array_search($blockToDeleteId["id"], $arrPageBlocksId);
                if ($idx !== false) {
                    unset($arrPageBlocksId[$idx]);
                }
            }
            $this->updatePageBlocksById($page["id"], implode(",", $arrPageBlocksId));
        }
        foreach ($arrBlocks as $block) {
            $this->delete("Blocks", ["id" => $block["id"]]);
        }
        return $this->delete("TypesOfBlocks", ["id" => $typeBlockId]);
    }

    public function deleteMetaBlockById($metaBlockId)
    {
        return $this->delete("MetaBlocks", ["id" => $metaBlockId]);
    }

    public function deletePageById($pageId)
    {
        $arrBlocks = $this->getPageBlocksIdByPageId($pageId);
        foreach($arrBlocks as $blockId) {
            $this->deleteBlockById($blockId);
        }
        return $this->delete("Pages", ["id" => $pageId]);
    }

    public function getTypeOfBlocksById($typeBlockId) {
        return $this->select("TypesOfBlocks", ["type"], ["id" => $typeBlockId])[0]["type"];
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

    public function getPagePropertyByPageId($id) {
        return $this->select("Pages", ["*"], ["id" => $id])[0];
    }
}
