<?php

// случайные значения A, B, C для первой загрузки
$randA = mt_rand(0, 100);
$randB = mt_rand(0, 100);
$randC = mt_rand(0, 100);

// если страница открыта повторно через «Повторить тест» — берём ФИО и группу из GET
$prefill_fio   = isset($_GET['fio'])   ? $_GET['fio']   : '';
$prefill_group = isset($_GET['group']) ? $_GET['group'] : '';

$result   = null;
$out_text = '';

if (isset($_POST['A'])) {

    // приводим A, B, C к числу (меняем запятую на точку)
    $A = floatval(str_replace(',', '.', $_POST['A']));
    $B = floatval(str_replace(',', '.', $_POST['B']));
    $C = floatval(str_replace(',', '.', $_POST['C']));

    // вычисляем результат в зависимости от задачи
    if ($_POST['TASK'] == 'mean') {
        $result = round(($A + $B + $C) / 3, 2);
        $task_name = 'Среднее арифметическое';
    } else if ($_POST['TASK'] == 'perimetr') {
        $result = $A + $B + $C;
        $task_name = 'Периметр треугольника';
    } else if ($_POST['TASK'] == 'area') {
        // площадь по формуле Герона
        $s = ($A + $B + $C) / 2;
        $result = round(sqrt($s * ($s - $A) * ($s - $B) * ($s - $C)), 2);
        $task_name = 'Площадь треугольника';
    } else if ($_POST['TASK'] == 'volume') {
        $result = $A * $B * $C;
        $task_name = 'Объём параллелепипеда';
    } else if ($_POST['TASK'] == 'max') {
        $result = max($A, $B, $C);
        $task_name = 'Максимум из трёх чисел';
    } else if ($_POST['TASK'] == 'min') {
        $result = min($A, $B, $C);
        $task_name = 'Минимум из трёх чисел';
    }

    // формируем отчёт в переменную (нужна и для браузера, и для почты)
    $out_text .= 'ФИО: ' . $_POST['FIO'] . '<br>';
    $out_text .= 'Группа: ' . $_POST['GROUP'] . '<br>';
    if ($_POST['ABOUT'])
        $out_text .= 'О себе: ' . $_POST['ABOUT'] . '<br>';
    $out_text .= 'Задача: ' . $task_name . '<br>';
    $out_text .= 'Входные данные: A=' . $A . ', B=' . $B . ', C=' . $C . '<br>';

    if ($_POST['USER_RESULT'] === '') {
        $out_text .= 'Задача самостоятельно решена не была<br>';
    } else {
        $out_text .= 'Ваш ответ: ' . $_POST['USER_RESULT'] . '<br>';
        $out_text .= 'Правильный ответ: ' . $result . '<br>';
        if (floatval(str_replace(',', '.', $_POST['USER_RESULT'])) == $result)
            $out_text .= '<b>Тест пройден</b><br>';
        else
            $out_text .= '<b>Ошибка: тест не пройден</b><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест математических знаний</title>
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px;
        font-family: Arial, sans-serif;
    }

    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }
    .form-row label {
        width: 200px;
        text-align: right;
        margin-right: 10px;
        font-size: 14px;
    }
    .form-row input[type="text"],
    .form-row textarea,
    .form-row select {
        width: 220px;
        height: 30px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 14px;
        padding: 2px 6px;
    }
    .form-row textarea {
        height: 70px;
        resize: vertical;
    }

    /* кнопка как ссылка */
    a.btn {
        display: inline-block;
        padding: 8px 24px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: black;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
    }
    a.btn:hover { background: #ccc; }

    input[type="submit"] {
        margin-top: 10px;
        padding: 8px 24px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }
    input[type="submit"]:hover { background: #ccc; }

    .result-box {
        border: 2px solid #999;
        background: #f9f9f9;
        padding: 20px 30px;
        font-size: 15px;
        line-height: 1.8;
        min-width: 400px;
    }
    .result-box.print {
        border: none;
        background: white;
    }
    </style>
</head>
<body>

<?php if (isset($_POST['A'])): ?>

    <!-- ===== ВЫВОД РЕЗУЛЬТАТА ===== -->

    <?php
    $is_print = (isset($_POST['VIEW']) && $_POST['VIEW'] == 'print');
    $box_class = $is_print ? 'result-box print' : 'result-box';
    ?>

    <div class="<?php echo $box_class; ?>">
        <?php echo $out_text; ?>

        <?php if (isset($_POST['send_mail']) && $_POST['MAIL']): ?>
            <?php
            // отправляем письмо (работает если настроен sendmail на сервере)
            $plain = str_replace('<br>', "\r\n", strip_tags($out_text));
            mail($_POST['MAIL'], 'Результат тестирования', $plain,
                "From: auto@test.local\r\nContent-Type: text/plain; charset=utf-8\r\n");
            ?>
            <br>Результаты теста были автоматически отправлены на e-mail: <?php echo $_POST['MAIL']; ?><br>
        <?php endif; ?>

        <?php if (!$is_print): ?>
            <br>
            <a class="btn" href="?fio=<?php echo urlencode($_POST['FIO']); ?>&group=<?php echo urlencode($_POST['GROUP']); ?>">Повторить тест</a>
        <?php endif; ?>
    </div>

<?php else: ?>

    <!-- ===== ФОРМА ===== -->

    <form method="post" action="/">

        <div class="form-row">
            <label>ФИО:</label>
            <input type="text" name="FIO" value="<?php echo htmlspecialchars($prefill_fio); ?>">
        </div>
        <div class="form-row">
            <label>Номер группы:</label>
            <input type="text" name="GROUP" value="<?php echo htmlspecialchars($prefill_group); ?>">
        </div>
        <div class="form-row">
            <label>Значение A:</label>
            <input type="text" name="A" value="<?php echo $randA; ?>">
        </div>
        <div class="form-row">
            <label>Значение B:</label>
            <input type="text" name="B" value="<?php echo $randB; ?>">
        </div>
        <div class="form-row">
            <label>Значение C:</label>
            <input type="text" name="C" value="<?php echo $randC; ?>">
        </div>
        <div class="form-row">
            <label>Задача:</label>
            <select name="TASK" style="height:34px;">
                <option value="area">Площадь треугольника</option>
                <option value="perimetr">Периметр треугольника</option>
                <option value="volume">Объём параллелепипеда</option>
                <option value="mean">Среднее арифметическое</option>
                <option value="max">Максимум из трёх чисел</option>
                <option value="min">Минимум из трёх чисел</option>
            </select>
        </div>
        <div class="form-row">
            <label>Ваш ответ:</label>
            <input type="text" name="USER_RESULT" value="">
        </div>
        <div class="form-row">
            <label>Немного о себе:</label>
            <textarea name="ABOUT"></textarea>
        </div>
        <div class="form-row">
            <label>Вид:</label>
            <select name="VIEW" style="height:34px;">
                <option value="browser">Версия для просмотра в браузере</option>
                <option value="print">Версия для печати</option>
            </select>
        </div>
        <div class="form-row">
            <label>Отправить на e-mail:</label>
            <input type="checkbox" name="send_mail" onclick="
                var obj = document.getElementById('email_block');
                if (this.checked) obj.style.display = 'flex';
                else obj.style.display = 'none';
            ">
        </div>
        <div class="form-row" id="email_block" style="display:none;">
            <label>Ваш e-mail:</label>
            <input type="text" name="MAIL" value="">
        </div>

        <div class="form-row">
            <label></label>
            <input type="submit" value="Проверить">
        </div>

    </form>

<?php endif; ?>

</body>
</html>
