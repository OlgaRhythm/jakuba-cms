<?php
// admin (edit) Редактирование существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Редактирование мета блока";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$metaBlockId = 0;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: /edit/metaBlocks.php");
    exit();
}

$metaBlockId = intval($_GET["id"]);

$metaBlockProperties = $dbPages->getMetaBlockPropertiesById($metaBlockId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbPages->updateMetaBlock($metaBlockProperties["id"], ["name" => $_POST["name"], "description" => $_POST["description"], "content" => $_POST["content"], "path" => $editView->prepare_folder($_POST["path"])]);
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "header.php";

$metaBlockProperties = $dbPages->getMetaBlockPropertiesById($metaBlockId);

?>

<h1>Редактировать мета блок id = <?= $metaBlockProperties["id"] ?></h1>
<form method="post" action="">
    <label for="name">Название мета блока</label>
    <input type="text" id="name" name="name" value="<?=$metaBlockProperties["name"]?>"><br>
    <label for="description">Описание мета блока</label>
    <input type="text" id="description" name="description" value="<?=$metaBlockProperties["description"]?>"><br>
    <label for="path">Папка с шаблоном типа блока</label>
    <input type="text" id="path" name="path" value="<?=$metaBlockProperties["path"]?>"><br>
    <label for="description">Содержимое мета блока</label>
    <input type="text" id="content" name="content" value="<?=$metaBlockProperties["content"]?>"><br><br>
    <input type="submit" value="Сохранить">

    <?php if (isset($error)) {
        echo $error;
    } ?>
    <br>
    
</form>



<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "footer.php";
