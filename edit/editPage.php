<?php
// admin (edit) Редактирование существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Редактирование страницы";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$pageId = 0;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: /edit");
    exit();
}

$pageId = intval($_GET["id"]);
$arrPageBlockIds = $dbPages->getPageBlocksIdByPageId($pageId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["createNewBlock"] == "createNewBlock") {
        if (isset($_POST["newBlock"]) && $_POST["newBlock"] != "" && intval($_POST["newBlock"]) > 0) {
            $blockType = $_POST["newBlock"];
            $arrPageBlockIds[] = $dbPages->createNewBlock($blockType); // добавить новые элементы в массив
            $dbPages->updatePageBlocksById($pageId, implode(",", $arrPageBlockIds));
        }
    } else {
        if (isset($_POST["deleteBlock"]) && !empty($_POST["deleteBlock"])) {
            foreach ($arrPageBlockIds as $keyBlockId => $blockId) {
                if (in_array($blockId, $_POST["deleteBlock"])) {
                    unset($arrPageBlockIds[$keyBlockId]);
                    $dbPages->deleteBlockById($blockId);
                }
            }
            $dbPages->updatePageBlocksById($pageId, implode(",", $arrPageBlockIds));
        }
        foreach ($_POST as $keyPost => $valuePost) {
            if (strpos($keyPost, "block_") !== false) { // если это поле содержит блок
                if (!isset($_POST["deleteBlock"]) || empty($_POST["deleteBlock"]) || !in_array(strpos($keyPost, "block_"), $_POST["deleteBlock"])) { // блок из post не в списке на удаление
                    $dbPages->updateContentBlockById(intval(str_replace("block_", "", $keyPost)), $_POST[$keyPost]);
                }
            }
        }

        if (isset($_POST["title"]) && isset($_POST["url"])) {
            $url = $editView->prepare_url($_POST["url"]);
            if ($dbPages->getPageUrlById($pageId) == $_POST["url"] || $dbPages->checkUnicUrlPage($url)) {
                $dbPages->updatePageTitleUrlById($pageId, $_POST["title"], $url);
            } else {
                $error = "Страница с таким url уже существует!";
            }
        } else {
            $error = "Обязательные поля не заполнены!";
        }
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "header.php";

$arrBlocks = $dbPages->getPageBlocksByIds($arrPageBlockIds);

$pageProperties = $dbPages->getPagePropertyByPageId($pageId);

$arrAllBlocks = $dbPages->getAllBlockTypes();

$blockTypesList = $editView->getAllBlockTypes($arrAllBlocks);

?>

<h1>Редактировать страницу</h1>
<form method="post" action="">
    <p class="page_fields">
        <label for="title">Название страницы:</label>
        <input type="text" id="title" name="title" value="<?= $pageProperties['title'] ?>">
    </p>
    <p class="page_fields">
        <label for="url">Человекопонятный url:</label>
        <input type="text" id="url" name="url" value="<?= $pageProperties['url'] ?>">
    </p>

    <?php if (isset($error)) {
        echo $error;
    }

    foreach ($arrBlocks as $blockProperty) {
    ?>
        <div class="block_item">
            <h4>id <?= $blockProperty["id"] ?></h4>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_MODULES . "/" . "blocks" . "/" . $blockProperty['path'] . "/edit/index.php"; ?>
            <div class="block_item_controll">
                <a title="Переместить вниз" href="/edit/moveBlock.php?pageId=<?= $pageId ?>&blockId=<?= $blockProperty["id"] ?>&direction=-1">&darr;</a>
                <a title="Переместить вверх" href="/edit/moveBlock.php?pageId=<?= $pageId ?>&blockId=<?= $blockProperty["id"] ?>&direction=1">&uarr;</a>
                <span class="align-right">Удалить блок <input type="checkbox" class="remover" del_alert="Вы уверены, что хотите удалить этот блок?" value="<?= $blockProperty["id"] ?>" name="deleteBlock[]"></span>
            </div>
        </div>
    <?php
    } ?>
    <br>
    <input type="submit" value="Сохранить">
</form>
<form method="post" action="" class="create_new_block">
    <p>
        Добавить блок
        <select name="newBlock">
            <?= $blockTypesList ?>
        </select>
        <input type="hidden" name="createNewBlock" value="createNewBlock">
        <button>+</button>
    </p>
</form>



<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "footer.php";
