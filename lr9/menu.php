<?php

// Модуль меню. Функция getMenu() возвращает HTML-код главного меню
// (и подменю сортировки для пункта "Просмотр") в виде строки.
function getMenu()
{
    // допустимые значения параметра p; если параметр некорректен —
    // по умолчанию активен "Просмотр"
    $valid = array('viewer', 'add', 'edit', 'delete');
    if (!isset($_GET['p']) || !in_array($_GET['p'], $valid))
        $_GET['p'] = 'viewer';

    $p = $_GET['p'];
    $ret = '<div id="menu">';

    // главные пункты меню
    $items = array(
        'viewer' => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    );
    foreach ($items as $key => $label) {
        $ret .= '<a href="?p=' . $key . '"';
        if ($p == $key) $ret .= ' class="selected"'; // активный — красным
        $ret .= '>' . $label . '</a>';
    }

    // подменю сортировки выводится только для "Просмотр"
    if ($p == 'viewer') {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
        $sub = array(
            'byid'  => 'По умолчанию',
            'fam'   => 'По фамилии',
            'birth' => 'По дате рождения'
        );
        $ret .= '<div id="submenu">';
        foreach ($sub as $key => $label) {
            $ret .= '<a href="?p=viewer&sort=' . $key . '"';
            if ($sort == $key) $ret .= ' class="selected"';
            $ret .= '>' . $label . '</a>';
        }
        $ret .= '</div>';
    }

    $ret .= '</div>';
    return $ret;
}
