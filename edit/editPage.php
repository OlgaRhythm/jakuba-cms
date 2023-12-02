<?php
// admin (edit) Редактирование существующей страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
$title = "Редактирование страницы Admin";

require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");
$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$editView = new editView();
$pageId = 0;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: /edit");
} else {
    $pageId = intval($_GET["id"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка введенных данных
    /*
    if (isset($_POST["title"]) && isset($_POST["url"])) {
        $url = $pageEdit->prepare_url($_POST["url"]);
        if ($dbPages->checkUnicUrlPage($url)) {
            $id = $dbPages->createPage($_POST["title"], $url);
            if ($id) {
                header("location: /edit/editPage.php?id=" . $id); // Перенаправление на защищенную страницу
                exit;
                
            } else {
                $error = "Не удалось создать новую страницу!";
            }

        } else {
            $error = "Страница с таким url уже существует!";
        }
    } else {
        $error = "Обязательные поля не заполнены!";
    }
    */
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "dbPageBlocks.php");
$dbPageBlocks = new DBPageBlocks(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$arrBlockIds = $dbPageBlocks->getPageBlocksIdByPageId($pageId);

$arrBlocks = $dbPageBlocks->getPageBlocksByIds($arrBlockIds);
$pageProperties = $dbPageBlocks->getPagePropertyByPageId($pageId);

$arrAllBlocks = $dbPages->getAllBlockTypes();

$blockTypesList = $editView->getAllBlockTypes($arrAllBlocks);

?>

<h1>Редактировать страницу</h1>
<form method="post" action="">
        <label for="title">Название страницы</label>
        <input type="text" id="title" name="title" value="<?=$pageProperties['title']?>"><br>
        <label for="url">Человекопонятный url</label>
        <input type="text" id="url" name="url" value="<?=$pageProperties['url']?>"><br><br>
        <input type="submit" value="Сохранить">
</form>

<?php if(isset($error)) { echo $error; } ?>

<form>
    <p>
        Добавить блок
        <select>
            <?=$blockTypesList?>
        </select>
        <button>+</button>
    </p>
</form>



<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/footer.php";