<? //main template
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->pageTitle ?></title>
    <link rel="stylesheet" type="text/css" href="/<?= DIR_TEMPLATES ?>/<?= DIR_MAINTEMPLATE ?>/css/style.css">

</head>

<body>
    <!-- СЮДА ВСТАВЛЯТЬ КОД ДЛЯ МЕТА БЛОКОВ -->
    <header><? $metaBlocks->showMetaBlockById(8); ?></header>
    <menu><? $metaBlocks->showMetaBlockById(6); ?></menu>
    <div class="content">