<?php
// admin (/edit)
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Мета блоки";
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE  . "/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");


$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
?>

<h1>Список мета блоков</h1>
<table>
<?=$editView->showMetaBlocks($dbPages->getAllMetaBlocks());?>
</table>

<p>
    <a class="create_button" href="/edit/createMetaBlock.php" title="Создать новый мета блок">
        Создать новый мета блок
    </a>
</p>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/" . "footer.php";