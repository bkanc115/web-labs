<?php

$cols = 3;

$tables = array(
    "Яблоко*Банан*Вишня#Груша*Апельсин*Лимон#Слива*Персик*Манго",
    "Кот*Собака*Попугай#Рыбка*Хомяк*Черепаха#Кролик*Ящерица*Канарейка",
    "Москва*Париж*Лондон#Берлин*Рим*Мадрид",
    "PHP*Python*Java#C++*Ruby*Go#Swift*Kotlin*Rust#HTML*CSS*JavaScript",
    "Красный*Синий*Зелёный#Жёлтый*Фиолетовый*Оранжевый#Белый*Чёрный*Серый",
    "Математика*Физика#Химия*Биология",
    "Один*Два*Три*Четыре#Пять*Шесть*Семь*Восемь",
    "Понедельник*Вторник*Среда#Четверг*Пятница*Суббота#Воскресенье**",
    "",
    "##",
    "Альфа*Бета*Гамма",
    "Земля*Марс*Венера#Юпитер*Сатурн*Уран#Нептун*Меркурий*Плутон"
);

function getTR($data, $cols)
{
    if (trim($data) === '') {
        return '';
    }

    $arr = explode('*', $data);

    $ret = '<tr>';
    for ($i = 0; $i < $cols; $i++) {
        if (isset($arr[$i])) {
            $ret .= '<td>' . $arr[$i] . '</td>';
        } else {
            $ret .= '<td></td>';
        }
    }
    $ret .= '</tr>';
    return $ret;
}

function outTable($structure, $cols, $num)
{
    echo "<h2>Таблица №$num</h2>";

    if (trim($structure) === '') {
        echo '<div class="warning">В таблице нет строк</div>';
        return;
    }

    $strings = explode('#', $structure);

    $datas = '';
    for ($i = 0; $i < count($strings); $i++) {
        $datas .= getTR($strings[$i], $cols);
    }

    if ($datas) {
        echo '<table>' . $datas . '</table>';
    } else {
        echo '<div class="warning">В таблице нет строк с ячейками</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №4</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }

        h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 5px;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            border: 2px solid #999;
            background: #e8e8e8;
            padding: 8px 15px;
            text-align: center;
            font-size: 16px;
        }

        .warning {
            border: 2px solid #999;
            background: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php

if ($cols <= 0) {
    echo '<div class="warning">Неправильное число колонок</div>';
} else {
    for ($i = 0; $i < count($tables); $i++) {
        outTable($tables[$i], $cols, $i + 1);
    }
}

?>

</body>
</html>
