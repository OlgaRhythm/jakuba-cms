<?php
// root/jakuba
/** Агрегация данных и передача в виде объекта */
class pageView {
    public $pageTitle;
    public $pageBlocksInfo;
    public $pageProperties;

    public function test() {
        return "Ok";
    }

    public function __construct($pageProperties, $pageBlocks) {
        $this->pageTitle = $pageProperties["title"];
        $this->pageBlocksInfo = $pageBlocks;
        $this->pageProperties = $pageProperties;
    }
    
    public function getTitle() {
        return $this->pageTitle;
    }

    public function getPageBlockById($blockId){
        foreach ($this->pageBlocksInfo as $blockProperty){
            if ($blockProperty["id"] == $blockId) {
                include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php"; 
                return true;
            }
        }
    }

    public function getPageBlocks(){
        foreach ($this->pageBlocksInfo as $blockProperty) {
            include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/view/index.php"; 
        }
    }

}