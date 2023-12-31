<?php
// admin (edit) Редактирование существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Редактирование типа блока";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$blockTypeId = 0;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: /edit/blocks.php");
    exit();
}

$blockTypeId = intval($_GET["id"]);

$blockTypeProperties = $dbPages->getTypeOfBlockPropertiesById($blockTypeId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["path"])) {
        if ($blockTypeProperties["type"] == $_POST["type"] || $dbPages->checkUnicTypeBlock($_POST["type"])) {
            $dbPages->updateTypeOfBlock($blockTypeProperties["id"], ["name" => $_POST["name"], "description" => $_POST["description"], "type" => $_POST["type"], "path" => $editView->prepare_folder($_POST["path"])]);
        } else {
            $error = "Блок с таким типом уже существует!";
        }
    } else {
        $error = "Обязательные поля не заполнены!";
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "header.php";

$blockTypeProperties = $dbPages->getTypeOfBlockPropertiesById($blockTypeId);

?>

<h1>Редактировать тип блока <?= $blockTypeProperties["type"] ?></h1>
<form method="post" action="">
    <p class="page_fields">
        <label for="name">Название типа блока</label>
        <input type="text" id="name" name="name" value="<?= $blockTypeProperties['name'] ?>">
    </p>
    <p class="page_fields">
        <label for="description">Описание типа блока</label>
        <textarea id="description" name="description"><?= $blockTypeProperties['description'] ?></textarea>
    </p>
    <p class="page_fields">
        <label for="type">Символьний идентификатор типа блока</label>
        <input type="text" id="type" name="type" value="<?= $blockTypeProperties['type'] ?>"><br>
    </p>
    <p class="page_fields">
        <label for="path">Папка с шаблоном типа блока</label>
        <input type="text" id="path" name="path" value="<?= $blockTypeProperties['path'] ?>">
    </p>
    <input type="submit" value="Сохранить">
    <?php if (isset($error)) {
        echo $error;
    } ?>
    <br>

</form>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "footer.php";
