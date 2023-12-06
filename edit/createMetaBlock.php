<?php
// admin (edit) Создание новой страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");

$title = "Создание мета блока";

$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$pageEdit = new editView();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $dbPages->createMetaBlock(["name" => $_POST["name"], "description" => $_POST["description"], "path" => $pageEdit->prepare_folder($_POST["path"]), "content" => $_POST["content"]]);
    if ($id) {
        header("location: /edit/metaBlocks.php");
        exit;
    } else {
        $error = "Не удалось создать новый мета блок!";
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "header.php";

?>

<h1>Создание мета блока</h1>
<form method="post" action="">
    <p class="page_fields">
        <label for="name">Название мета блока</label>
        <input type="text" id="name" name="name" value="">
    </p>
    <p class="page_fields">
        <label for="description">Описание мета блока</label>
        <textarea id="description" name="description"></textarea>
    </p>
    <p class="page_fields">
        <label for="path">Папка с шаблоном типа блока</label>
        <input type="text" id="path" name="path" value="">
    </p>
    <p class="page_fields">
        <label for="content">Содержимое мета блока</label>
        <textarea id="content" name="content"></textarea>
    </p>
    <input type="submit" value="Создать">


</form>
<?php if (isset($error)) {
    echo $error;
} ?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "footer.php";
