<?php require 'menu.php'; // главное меню подключаем всегда через require ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f5f5;
    }

    /* ===== ГЛАВНОЕ МЕНЮ ===== */
    #menu {
        background: #333;
        padding: 10px;
    }
    #menu > a {
        display: inline-block;
        padding: 8px 18px;
        margin-right: 4px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: #0066cc;          /* пункты меню синие */
        font-weight: bold;
    }
    #menu > a:hover { background: #ccc; }
    #menu > a.selected { color: red; }   /* активный — красный */

    /* ===== ПОДМЕНЮ СОРТИРОВКИ ===== */
    #submenu {
        margin-top: 8px;
    }
    #submenu a {
        display: inline-block;
        padding: 4px 12px;       /* визуально меньше главных */
        margin-right: 4px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: #0066cc;
        font-size: 13px;
    }
    #submenu a:hover { background: #ccc; }
    #submenu a.selected { color: red; }

    /* ===== КОНТЕНТ ===== */
    .content { padding: 20px; }

    /* таблица данных */
    table.data {
        border-collapse: collapse;
        background: white;
    }
    table.data th, table.data td {
        border: 2px solid #999;
        padding: 6px 10px;
        font-size: 13px;
        text-align: left;
    }
    table.data th { background: #e8e8e8; }

    /* пагинация */
    #pages {
        margin-top: 12px;
        font-size: 14px;
    }
    #pages a, #pages span {
        display: inline-block;
        padding: 4px 8px;
        margin: 0 2px;
        text-decoration: none;
        color: #0066cc;
    }
    #pages a:hover { border: 2px solid #999; }  /* рамка 2px при наведении */
    #pages span { color: black; font-weight: bold; }

    /* формы добавления/редактирования */
    .record-form {
        display: flex;
        flex-direction: column;
        max-width: 400px;
    }
    .record-form label {
        display: flex;
        flex-direction: column;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .record-form input, .record-form select, .record-form textarea {
        border: 2px solid #999;
        background: #e8e8e8;
        padding: 5px;
        font-size: 14px;
        margin-top: 2px;
    }
    .record-form textarea { height: 60px; resize: vertical; }
    .record-form input[type="submit"] {
        font-weight: bold;
        cursor: pointer;
        margin-top: 8px;
    }
    .record-form input[type="submit"]:hover { background: #ccc; }

    /* списки ссылок (редактирование/удаление) */
    #edit_links, #delete_links {
        margin-bottom: 15px;
    }
    #edit_links a, #delete_links a, #edit_links .current {
        display: inline-block;
        padding: 6px 12px;
        margin: 2px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: #0066cc;
    }
    #edit_links a:hover, #delete_links a:hover { background: #ccc; }
    #edit_links .current { color: red; }   /* текущая запись выделена */

    /* сообщения */
    .ok    { color: green; font-weight: bold; margin-bottom: 10px; }
    .error { color: red;   font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

<?php echo getMenu(); // выводим меню (оно же выставляет $_GET['p'] по умолчанию) ?>

<div class="content">
<?php

if ($_GET['p'] == 'viewer') {
    include 'viewer.php'; // подключаем библиотеку функций

    // проверка и установка параметров по умолчанию
    if (!isset($_GET['pg']) || $_GET['pg'] < 0)
        $_GET['pg'] = 0;
    if (!isset($_GET['sort']) || ($_GET['sort'] != 'byid' && $_GET['sort'] != 'fam' && $_GET['sort'] != 'birth'))
        $_GET['sort'] = 'byid';

    echo getFriendsList($_GET['sort'], $_GET['pg']);

} else if (file_exists($_GET['p'] . '.php')) {
    // имя модуля совпадает со значением параметра p
    include $_GET['p'] . '.php';
}

?>
</div>

</body>
</html>
