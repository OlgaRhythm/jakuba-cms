<?php
// admin (/edit)
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Главная Admin";
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");


$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$table = new editView();
?>

<h1>Страницы</h1>
<table>
<?=$table->showPages($dbPages->getAllPages());?>
</table>

<p>
    <a href="/edit/createPage.php" title="Создать новую страницу">
        Создать новую страницу
    </a>
</p>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/footer.php";