<?php
// admin (edit) Создание новой страницы
require_once($_SERVER['DOCUMENT_ROOT'] . "/" ."config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/load.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/" . "db.php");

$title = "Создание страницы Admin";

$dbPages = new DBEdit(DB_NAME, DB_USER, DB_PASSWORD, DB_HOST);
$pageEdit = new editView();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка введенных данных

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
}

include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/header.php";

?>

<h1>Создать страницу</h1>
<form method="post" action="">
        <label for="title">Название страницы</label>
        <input type="text" id="title" name="title"><br>
        <label for="url">Человекопонятный url</label>
        <input type="text" id="url" name="url"><br><br>
        <input type="submit" value="Создать">
</form>
<?php if(isset($error)) { echo $error; } ?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN . "/template/footer.php";