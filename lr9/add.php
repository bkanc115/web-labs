<form name="form_add" method="post" action="?p=add" class="record-form">
    <label>Фамилия: <input type="text" name="surname"></label>
    <label>Имя: <input type="text" name="name"></label>
    <label>Отчество: <input type="text" name="patronymic"></label>
    <label>Пол:
        <select name="gender">
            <option value="Мужской">Мужской</option>
            <option value="Женский">Женский</option>
        </select>
    </label>
    <label>Дата рождения: <input type="date" name="birthdate"></label>
    <label>Телефон: <input type="text" name="phone"></label>
    <label>Адрес: <input type="text" name="address"></label>
    <label>E-mail: <input type="text" name="email"></label>
    <label>Комментарий: <textarea name="comment"></textarea></label>
    <input type="submit" name="button" value="Добавить запись">
</form>

<?php

// если форма была отправлена — добавляем запись в БД
if (isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {
    require 'db.php';

    // экранируем все значения для безопасной вставки
    $surname    = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name       = mysqli_real_escape_string($mysqli, $_POST['name']);
    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
    $gender     = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $birthdate  = mysqli_real_escape_string($mysqli, $_POST['birthdate']);
    $phone      = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address    = mysqli_real_escape_string($mysqli, $_POST['address']);
    $email      = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment    = mysqli_real_escape_string($mysqli, $_POST['comment']);

    // поле id не указываем — оно автоинкрементное
    $sql = 'INSERT INTO friends (surname, name, patronymic, gender, birthdate, phone, address, email, comment)
            VALUES ("' . $surname . '", "' . $name . '", "' . $patronymic . '", "' . $gender . '",
                    "' . $birthdate . '", "' . $phone . '", "' . $address . '", "' . $email . '", "' . $comment . '")';
    mysqli_query($mysqli, $sql);

    if (mysqli_errno($mysqli))
        echo '<div class="error">Ошибка: запись не добавлена</div>';
    else
        echo '<div class="ok">Запись добавлена</div>';
}

?>
