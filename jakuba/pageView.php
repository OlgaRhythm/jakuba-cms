<?php
/** Агрегация данных и передача в виде объекта */
class pageView {
    private $pageTitle;

    public function test() {
        return "Ok";
    }

    public function __construct($pageProperties, $pageBlocks) {
        $this->pageTitle = $pageProperties["title"];
    }
    
    public function getTitle() {
        return $this->pageTitle;
    }

}