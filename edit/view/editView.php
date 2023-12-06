<?php
///edit/view

/**
 * Класс для вывода блоков на страницах управления сайтом
 */
class editView
{
    // `id`, `title`, `url`, `blocks`

    public function showPages(array $arrayPages)
    {
        $echo = '<tr>
                    <th>ID</th><th>Название</th><th>Ссылка</th><th>Количество блоков</th><th>Редактировать</th><th>Удалить</th>
                </tr>' . "\n";
        foreach ($arrayPages as $page) {
            $echo .= '<tr>';
            $echo .= '<td>' . $page["id"] . '</td>';
            $echo .= '<td><a href="' . $page["url"] . '" target="_blank">' . $page["title"] . '</a></td>';
            $echo .= '<td><a href="' . $page["url"] . '" target="_blank">' . $page["url"] . '</a></td>';
            $echo .= '<td>' . count(array_filter(explode(",", $page["blocks"]))) . '</td>';
            $echo .= '<td><a href="/edit/editPage.php?id=' . $page["id"] . '">Редактировать</a></td>';
            $echo .= '<td><a class="deletePage" href="/edit/deletePage.php?id=' . $page["id"] . '">Удалить</a></td>';
            $echo .= '</tr>' . "\n";
        }
        return $echo;
    }

    public function showBlocks(array $arrayBlocks)
    {
        $echo = '<tr>
                    <th>ID</th><th>Название</th><th>Описание</th><th>Путь</th><th>Тип</th><th>Редактировать</th><th>Удалить</th>
                </tr>' . "\n";
        foreach ($arrayBlocks as $block) {
            $echo .= '<tr>';
            $echo .= '<td>' . $block["id"] . '</td>';
            $echo .= '<td>' . $block["name"] . '</td>';
            $echo .= '<td>' . $block["description"] . '</td>';
            $echo .= '<td>' . "/" . DIR_MODULES . "/blocks" . "/" . $block["path"] . '/</td>';
            $echo .= '<td>' . $block["type"] . '</td>';
            $echo .= '<td><a href="/edit/editBlock.php?id=' . $block["id"] . '">Редактировать</a></td>';
            $echo .= '<td><a href="/edit/deleteBlock.php?id=' . $block["id"] . '">Удалить</a></td>';
            $echo .= '</tr>' . "\n";
        }
        return $echo;
    }

    public function showMetaBlocks(array $arrayMetaBlocks)
    {
        $echo = '<tr>
                    <th>ID</th><th>Название</th><th>Описание</th><th>Путь</th><th>Код вставки</th><th>Редактировать</th><th>Удалить</th>
                </tr>' . "\n";
        foreach ($arrayMetaBlocks as $block) {
            $echo .= '<tr>';
            $echo .= '<td>' . $block["id"] . '</td>';
            $echo .= '<td>' . $block["name"] . '</td>';
            $echo .= '<td>' . $block["description"] . '</td>';
            $echo .= '<td>' . "/" . DIR_MODULES . "/metaBlocks" . "/" . $block["path"] . '/</td>';
            $echo .= '<td><input type="text" value="'. htmlspecialchars('<?=$metaBlocks->showMetaBlockById(' . $block["id"] . ')?>') .'"></td>';
            $echo .= '<td><a href="/edit/editMetaBlock.php?id=' . $block["id"] . '">Редактировать</a></td>';
            $echo .= '<td><a href="/edit/deleteMetaBlock.php?id=' . $block["id"] . '">Удалить</a></td>';
            $echo .= '</tr>' . "\n";
        }
        return $echo;
    }

    public function prepare_url($url)
    { // человекопонятный url
        $arr_url = array_filter(explode("/", $url), 'strlen');
        $url = implode("/", $arr_url);
        if ($url) {
            return "/" . $url . "/";
        }
        return "/";
    }

    public function prepare_folder($folder)
    {
        // Удаляем символы, которые не являются буквами, цифрами, пробелами или дефисами
        $folder = preg_replace("/[^A-Za-z0-9\- ]/", '', $folder);
        // Заменяем пробелы на дефисы
        $folder = str_replace(' ', '-', $folder);
        // Преобразуем в нижний регистр
        $folder = strtolower($folder);
        return $folder;
    }


    public function getAllBlockTypes(array $pageBlocksInfo)
    {
        $echo = '<option value="0">Выберите тип блока</option>' . "\n";
        foreach ($pageBlocksInfo as $block) {
            $echo .= '<option value="' . $block["id"] . '">' . $block["type"] . '</option>' . "\n";
        }
        return $echo;
    }
}
