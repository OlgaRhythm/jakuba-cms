<?php
// admin (edit) Редактирование существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Редактирование страницы Admin";
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");


$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$table = new editView();
?>

<h1>Редактировать страницу</h1>
<table>
<?=$table->showPages($dbPages->getAllPages());?>
</table>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/footer.php";