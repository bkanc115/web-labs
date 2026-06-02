<?php

require 'db.php';

// если форма отправлена — обновляем запись по id из GET
if (isset($_POST['button']) && $_POST['button'] == 'Изменить запись') {
    $id = intval($_GET['id']);

    $surname    = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name       = mysqli_real_escape_string($mysqli, $_POST['name']);
    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
    $gender     = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $birthdate  = mysqli_real_escape_string($mysqli, $_POST['birthdate']);
    $phone      = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address    = mysqli_real_escape_string($mysqli, $_POST['address']);
    $email      = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment    = mysqli_real_escape_string($mysqli, $_POST['comment']);

    $sql = 'UPDATE friends SET
                surname="' . $surname . '", name="' . $name . '", patronymic="' . $patronymic . '",
                gender="' . $gender . '", birthdate="' . $birthdate . '", phone="' . $phone . '",
                address="' . $address . '", email="' . $email . '", comment="' . $comment . '"
            WHERE id=' . $id;
    mysqli_query($mysqli, $sql);
    echo '<div class="ok">Данные изменены</div>';
}

// получаем текущую запись (по id из GET) — отдельным запросом
$currentROW = array();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = mysqli_query($mysqli, 'SELECT * FROM friends WHERE id=' . $id . ' LIMIT 0, 1');
    $currentROW = mysqli_fetch_assoc($res);
}
// если запись не выбрана или не найдена — берём первую по порядку
if (!$currentROW) {
    $res = mysqli_query($mysqli, 'SELECT * FROM friends ORDER BY surname, name LIMIT 0, 1');
    $currentROW = mysqli_fetch_assoc($res);
}

// список ссылок для выбора записи (сортировка по фамилии, затем по имени)
$res = mysqli_query($mysqli, 'SELECT id, surname, name FROM friends ORDER BY surname, name');
if (!mysqli_errno($mysqli)) {

    echo '<div id="edit_links">';
    while ($row = mysqli_fetch_assoc($res)) {
        $text = $row['surname'] . ' ' . $row['name'];
        // текущую запись выделяем (выводим блоком, а не ссылкой)
        if ($currentROW && $currentROW['id'] == $row['id'])
            echo '<div class="current">' . $text . '</div>';
        else
            echo '<a href="?p=edit&id=' . $row['id'] . '">' . $text . '</a>';
    }
    echo '</div>';

    // форма редактирования — заполняется данными текущей записи
    if ($currentROW) {
        echo '<form name="form_edit" method="post" action="?p=edit&id=' . $currentROW['id'] . '" class="record-form">';
        echo '<label>Фамилия: <input type="text" name="surname" value="' . htmlspecialchars($currentROW['surname']) . '"></label>';
        echo '<label>Имя: <input type="text" name="name" value="' . htmlspecialchars($currentROW['name']) . '"></label>';
        echo '<label>Отчество: <input type="text" name="patronymic" value="' . htmlspecialchars($currentROW['patronymic']) . '"></label>';

        // селектор пола с выбранным текущим значением
        echo '<label>Пол: <select name="gender">';
        $m = ($currentROW['gender'] == 'Мужской') ? ' selected' : '';
        $f = ($currentROW['gender'] == 'Женский') ? ' selected' : '';
        echo '<option value="Мужской"' . $m . '>Мужской</option>';
        echo '<option value="Женский"' . $f . '>Женский</option>';
        echo '</select></label>';

        echo '<label>Дата рождения: <input type="date" name="birthdate" value="' . htmlspecialchars($currentROW['birthdate']) . '"></label>';
        echo '<label>Телефон: <input type="text" name="phone" value="' . htmlspecialchars($currentROW['phone']) . '"></label>';
        echo '<label>Адрес: <input type="text" name="address" value="' . htmlspecialchars($currentROW['address']) . '"></label>';
        echo '<label>E-mail: <input type="text" name="email" value="' . htmlspecialchars($currentROW['email']) . '"></label>';
        echo '<label>Комментарий: <textarea name="comment">' . htmlspecialchars($currentROW['comment']) . '</textarea></label>';
        echo '<input type="submit" name="button" value="Изменить запись">';
        echo '</form>';
    } else {
        echo '<p>Записей пока нет</p>';
    }

} else {
    echo '<div class="error">Ошибка базы данных</div>';
}
