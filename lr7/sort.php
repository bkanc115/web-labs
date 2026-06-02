<?php

// ======== ВАЛИДАЦИЯ ========

if (!isset($_POST['element0'])) {
    echo 'Массив не задан, сортировка невозможна';
    exit();
}

$len = intval($_POST['arrLength']);

// проверяем что все элементы — числа
for ($i = 0; $i < $len; $i++) {
    $val = $_POST['element' . $i];
    // заменяем запятую на точку для десятичных дробей
    $val = str_replace(',', '.', $val);
    if (!is_numeric($val) || $val === '') {
        echo 'Элемент массива "' . $_POST['element' . $i] . '" — не число. Сортировка невозможна.';
        exit();
    }
}

// ======== СОБИРАЕМ МАССИВ ========

$arr = array();
for ($i = 0; $i < $len; $i++) {
    $arr[] = floatval(str_replace(',', '.', $_POST['element' . $i]));
}

// ======== ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ========

$iter = 0; // счётчик итераций (сквозной)

// выводит текущее состояние массива с номером итерации
function showArr($arr) {
    global $iter;
    echo '<div class="step"><span class="iter">Итерация ' . $iter . ':</span> ';
    for ($i = 0; $i < count($arr); $i++) {
        echo '<span class="el">' . $arr[$i] . '</span>';
    }
    echo '</div>';
}

// ======== АЛГОРИТМЫ СОРТИРОВКИ ========

function selectionSort($arr) {
    global $iter;
    for ($i = 0; $i < count($arr) - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < count($arr); $j++) {
            $iter++;
            if ($arr[$j] < $arr[$min])
                $min = $j;
        }
        if ($min != $i) {
            $temp = $arr[$i]; $arr[$i] = $arr[$min]; $arr[$min] = $temp;
        }
        showArr($arr);
    }
}

function bubbleSort($arr) {
    global $iter;
    for ($j = 0; $j < count($arr) - 1; $j++) {
        for ($i = 0; $i < count($arr) - 1 - $j; $i++) {
            $iter++;
            if ($arr[$i] > $arr[$i + 1]) {
                $temp = $arr[$i]; $arr[$i] = $arr[$i + 1]; $arr[$i + 1] = $temp;
            }
        }
        showArr($arr);
    }
}

function shellSort($arr) {
    global $iter;
    for ($k = (int)ceil(count($arr) / 2); $k >= 1; $k = (int)ceil($k / 2)) {
        for ($i = $k; $i < count($arr); $i++) {
            $iter++;
            $val = $arr[$i];
            $j = $i - $k;
            while ($j >= 0 && $arr[$j] > $val) {
                $arr[$j + $k] = $arr[$j];
                $j -= $k;
                $iter++;
            }
            $arr[$j + $k] = $val;
        }
        showArr($arr);
        if ($k == 1) break; // предотвращаем бесконечный цикл при k=1
    }
}

function gnomeSort($arr) {
    global $iter;
    $i = 1;
    $j = 2;
    while ($i < count($arr)) {
        $iter++;
        if (!$i || $arr[$i - 1] <= $arr[$i]) {
            $i = $j;
            $j++;
        } else {
            $temp = $arr[$i]; $arr[$i] = $arr[$i - 1]; $arr[$i - 1] = $temp;
            $i--;
        }
        showArr($arr);
    }
}

// быстрая сортировка — передаём массив по ссылке
function quickSortStep(&$arr, $left, $right) {
    global $iter;
    $l = $left;
    $r = $right;
    $point = $arr[floor(($left + $right) / 2)]; // опорная точка — средний элемент
    do {
        while ($arr[$l] < $point) $l++;
        while ($arr[$r] > $point) $r--;
        if ($l <= $r) {
            $iter++;
            $temp = $arr[$l]; $arr[$l] = $arr[$r]; $arr[$r] = $temp;
            $l++; $r--;
            showArr($arr);
        }
    } while ($l <= $r);
    if ($r > $left)  quickSortStep($arr, $left, $r);
    if ($l < $right) quickSortStep($arr, $l, $right);
}

// обёртка для вызова без указания границ
function quickSort(&$arr) {
    quickSortStep($arr, 0, count($arr) - 1);
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат сортировки</title>
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        font-family: Arial, sans-serif;
    }
    h2 { margin-bottom: 6px; }
    .info {
        border: 2px solid #999;
        background: #e8e8e8;
        padding: 10px 20px;
        margin-bottom: 10px;
        font-size: 15px;
    }
    .step {
        font-size: 14px;
        margin: 2px 0;
    }
    .iter {
        display: inline-block;
        width: 120px;
        color: #555;
    }
    .el {
        display: inline-block;
        min-width: 36px;
        height: 28px;
        line-height: 28px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-align: center;
        font-size: 14px;
        margin: 1px;
    }
    .done {
        border: 2px solid #999;
        background: #e8e8e8;
        padding: 10px 20px;
        margin-top: 12px;
        font-size: 15px;
        font-weight: bold;
    }
    </style>
</head>
<body>

<?php

// название алгоритма
$names = array(
    'selection' => 'Сортировка выбором',
    'bubble'    => 'Пузырьковый алгоритм',
    'shell'     => 'Алгоритм Шелла',
    'gnome'     => 'Алгоритм садового гнома',
    'quick'     => 'Быстрая сортировка',
    'builtin'   => 'Встроенная функция PHP (sort)'
);

$alg = $_POST['algoritm'];
echo '<h2>' . $names[$alg] . '</h2>';

// выводим исходный массив
echo '<div class="info">Исходный массив: ';
for ($i = 0; $i < count($arr); $i++) {
    echo '<span class="el">' . $arr[$i] . '</span>';
}
echo '<br>Все элементы являются числами — валидация пройдена.</div>';

// запускаем нужный алгоритм
$time = microtime(true);

if ($alg == 'selection') {
    selectionSort($arr);
} else if ($alg == 'bubble') {
    bubbleSort($arr);
} else if ($alg == 'shell') {
    shellSort($arr);
} else if ($alg == 'gnome') {
    gnomeSort($arr);
} else if ($alg == 'quick') {
    quickSort($arr);
} else if ($alg == 'builtin') {
    sort($arr);
    echo '<div class="step"><span class="iter">Результат:</span> ';
    foreach ($arr as $v) echo '<span class="el">' . $v . '</span>';
    echo '</div>';
}

$elapsed = round(microtime(true) - $time, 6);

echo '<div class="done">Сортировка завершена, проведено ' . $iter . ' итераций. Затрачено ' . $elapsed . ' секунд.</div>';

?>

</body>
</html>
