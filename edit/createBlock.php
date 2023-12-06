<?php
// admin (edit) Создание новой страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . "config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");

$title = "Создание типа блока";

$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$pageEdit = new editView();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["type"])) {
        if ($dbPages->checkUnicTypeBlock($_POST["type"])) {
            $id = $dbPages->createTypeOfBlock(["name" => $_POST["name"], "type" => $_POST["type"], "description" => $_POST["description"], "path" => $pageEdit->prepare_folder($_POST["path"])]);
            if ($id) {
                header("location: /edit/blocks.php");
                exit;
            } else {
                $error = "Не удалось создать новый тип блока!";
            }
        } else {
            $error = "Блок с таким типом уже существует!";
        }
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "header.php";

?>

<h1>Создание типа блока</h1>
<form method="post" action="">
    <p class="page_fields">
        <label for="name">Название типа блока</label>
        <input type="text" id="name" name="name" value="">
    </p>
    <p class="page_fields">
        <label for="description">Описание типа блока</label>
        <textarea id="description" name="description"></textarea>
    </p>
    <p class="page_fields">
        <label for="type">Символьний идентификатор типа блока</label>
        <input type="text" id="type" name="type" value=""><br>
    </p>
    <p class="page_fields">
        <label for="path">Папка с шаблоном типа блока</label>
        <input type="text" id="path" name="path" value="">
    </p>
    <input type="submit" value="Создать">

</form>
<?php if (isset($error)) {
    echo $error;
} ?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/"  . "footer.php";
