<?//menu для админки?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" type="text/css" href="/<?=DIR_ADMIN?>/<?=DIR_ADMIN_TEMPLATE?>/css/style.css">
</head>
<body>
<menu><?include $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_ADMIN  . "/verticalMenu.php";  ?></menu>
<div class="content">
