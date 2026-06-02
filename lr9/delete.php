<?php

require 'db.php';

// если передан id для удаления — удаляем запись
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // сначала узнаём фамилию (для сообщения), потом удаляем
    $res = mysqli_query($mysqli, 'SELECT surname FROM friends WHERE id=' . $id . ' LIMIT 0, 1');
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        mysqli_query($mysqli, 'DELETE FROM friends WHERE id=' . $id);
        echo '<div class="ok">Запись с фамилией ' . $row['surname'] . ' удалена</div>';
    }
}

// выводим список ссылок: фамилия + инициалы
$res = mysqli_query($mysqli, 'SELECT id, surname, name, patronymic FROM friends ORDER BY surname, name');
if (!mysqli_errno($mysqli)) {

    echo '<div id="delete_links">';
    while ($row = mysqli_fetch_assoc($res)) {
        // инициалы: первая буква имени и отчества (mb_substr — для кириллицы в UTF-8)
        $initials = mb_substr($row['name'], 0, 1) . '.';
        if ($row['patronymic'])
            $initials .= mb_substr($row['patronymic'], 0, 1) . '.';
        $text = $row['surname'] . ' ' . $initials;

        echo '<a href="?p=delete&id=' . $row['id'] . '">' . $text . '</a>';
    }
    echo '</div>';

} else {
    echo '<div class="error">Ошибка базы данных</div>';
}
