<?php
// root/jakuba
/** Вывод мета блоков */

class pageMetaBlocksView
{
    public $DBPageBlocks;

    public function __construct($DBPageBlocks)
    {
        $this->DBPageBlocks = $DBPageBlocks;
    }

    public function showMetaBlockById($metaBlockId)
    {
        if ($metaBlockId == -1) {
            include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/metaBlocks/default/view/index.php";
        } else {
            $metaBlockProperty = $this->DBPageBlocks->getMetaBlockPropertiesById($metaBlockId);
            if ($metaBlockProperty) {
                if ($metaBlockProperty['path'] == "") {
                    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/metaBlocks/default/view/index.php";
                } else {
                    include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "metaBlocks" . "/" . $metaBlockProperty['path'] . "/view/index.php";
                }
            }
        }
    }
}
