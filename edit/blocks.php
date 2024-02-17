<?php
// admin (/edit)
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Типы блоков";
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE  . "/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");


$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$table = new editView();
?>

<h1>Типы блоков</h1>
<table>
<?=$table->showBlocks($dbPages->getAllBlockTypes());?>
</table>

<p>
    <a class="create_button" href="/edit/createBlock.php" title="Создать новый блок">
        Создать новый блок
    </a>
</p>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/" . DIR_ADMIN_TEMPLATE . "/" . "footer.php";