<?php

// Модуль вывода содержимого книжки. Функция формирует таблицу записей
// (по 10 на страницу) и пагинацию. $type — тип сортировки, $page — номер страницы.
function getFriendsList($type, $page)
{
    require 'db.php'; // даёт $mysqli

    // считаем общее количество записей средствами SQL (COUNT)
    $res = mysqli_query($mysqli, 'SELECT COUNT(*) FROM friends');
    $row = mysqli_fetch_row($res);
    $TOTAL = $row[0];
    if (!$TOTAL)
        return '<p>В таблице нет данных</p>';

    $PAGES = ceil($TOTAL / 10); // всего страниц пагинации
    if ($page >= $PAGES)        // если запросили страницу больше максимума
        $page = $PAGES - 1;

    // определяем поле сортировки по типу
    $order = 'id';
    if ($type == 'fam')   $order = 'surname';
    if ($type == 'birth') $order = 'birthdate';

    // выбираем нужные 10 записей через LIMIT (смещение, количество)
    $offset = $page * 10;
    $sql = 'SELECT * FROM friends ORDER BY ' . $order . ' LIMIT ' . $offset . ', 10';
    $res = mysqli_query($mysqli, $sql);

    // формируем таблицу
    $ret = '<table class="data">';
    $ret .= '<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th>
             <th>Дата рожд.</th><th>Телефон</th><th>Адрес</th><th>E-mail</th><th>Комментарий</th></tr>';
    while ($row = mysqli_fetch_assoc($res)) {
        $ret .= '<tr>';
        $ret .= '<td>' . $row['surname'] . '</td>';
        $ret .= '<td>' . $row['name'] . '</td>';
        $ret .= '<td>' . $row['patronymic'] . '</td>';
        $ret .= '<td>' . $row['gender'] . '</td>';
        $ret .= '<td>' . date('d.m.Y', strtotime($row['birthdate'])) . '</td>';
        $ret .= '<td>' . $row['phone'] . '</td>';
        $ret .= '<td>' . $row['address'] . '</td>';
        $ret .= '<td>' . $row['email'] . '</td>';
        $ret .= '<td>' . $row['comment'] . '</td>';
        $ret .= '</tr>';
    }
    $ret .= '</table>';

    // пагинация выводится только если страниц больше одной
    if ($PAGES > 1) {
        $ret .= '<div id="pages">Страницы: ';
        for ($i = 0; $i < $PAGES; $i++) {
            // в адресе страницы с нуля, в тексте — с единицы
            if ($i != $page)
                $ret .= '<a href="?p=viewer&sort=' . $type . '&pg=' . $i . '">' . ($i + 1) . '</a>';
            else
                $ret .= '<span>' . ($i + 1) . '</span>'; // текущую не делаем ссылкой
        }
        $ret .= '</div>';
    }

    return $ret;
}
