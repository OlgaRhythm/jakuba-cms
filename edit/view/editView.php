<?php

class editView {
    // `id`, `title`, `url`, `blocks`

    public function showPages(array $arrayPages) {
        $echo = '<tr>
                    <th>ID</th><th>Название</th><th>Ссылка</th><th>Количество блоков</th><th>Редактировать</th>
                </tr>' . "\n";
        foreach ($arrayPages as $page) {
            $echo .= '<tr>';
            $echo .= '<td>' . $page["id"] . '</td>';
            $echo .= '<td><a href="' . $page["url"] . '" target="_blank">' . $page["title"] . '</a></td>';
            $echo .= '<td><a href="' . $page["url"] . '" target="_blank">' . $page["url"] . '</a></td>';
            $echo .= '<td>' . count(explode(",", $page["blocks"])) . '</td>';
            $echo .= '<td><a href="/edit/view/editpage.php?id=' . $page["id"] . '">Редактировать</a></td>';
            $echo .= '</tr>' . "\n";
        }
        return $echo;
    }
}