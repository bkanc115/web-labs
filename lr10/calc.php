<?php

session_start(); // подключаем сессии — ДО любого вывода

// первая загрузка: создаём историю и счётчик загрузок
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
    $_SESSION['iteration'] = 0;
}
$_SESSION['iteration']++; // каждая загрузка увеличивает счётчик


// ===== ПРОВЕРКА: ЯВЛЯЕТСЯ ЛИ СТРОКА ЧИСЛОМ =====
function isnum($x)
{
    $x = $x . ''; // приводим к строке через конкатенацию

    if ($x === '') return false;             // пустая строка — не число
    if ($x === '-') return false;            // один минус — не число

    // допускаем один ведущий минус (для отрицательных результатов)
    $body = $x;
    if ($x[0] === '-') $body = substr($x, 1);

    if ($body === '') return false;
    if ($body[0] === '.') return false;                  // не начинается с точки
    if ($body[strlen($body) - 1] === '.') return false;  // не заканчивается точкой

    $point = false;
    for ($i = 0; $i < strlen($body); $i++) {
        $c = $body[$i];
        if ($c == '.') {
            if ($point) return false; // вторая точка — не число
            $point = true;
        } else if ($c < '0' || $c > '9') {
            return false;             // посторонний символ
        }
    }

    // запрет ведущих нулей: "048" не число, но "0" и "0.5" — допустимы
    $ip = $body;
    $dot = strpos($body, '.');
    if ($dot !== false) $ip = substr($body, 0, $dot);
    if (strlen($ip) > 1 && $ip[0] === '0') return false;

    return true;
}


// ===== ВЫЧИСЛЕНИЕ ВЫРАЖЕНИЯ БЕЗ СКОБОК (рекурсия) =====
// Порядок разбора: + , - , * , /  (от низшего приоритета к высшему)
function calculate($val)
{
    if ($val === '') return 'Выражение не задано!';
    if (isnum($val)) return $val; // база рекурсии: число возвращаем как есть

    // --- сложение ---
    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg; // ошибка — сразу возвращаем
            $sum += $arg;
        }
        return $sum;
    }

    // --- вычитание ---
    $args = explode('-', $val);
    if (count($args) > 1) {
        $res = calculate($args[0]); // начальное значение — первый аргумент
        if (!isnum($res)) return $res;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            $res -= $arg;
        }
        return $res;
    }

    // --- умножение ---
    $args = explode('*', $val);
    if (count($args) > 1) {
        $prod = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            $prod *= $arg;
        }
        return $prod;
    }

    // --- деление (символ ":" заранее заменён на "/") ---
    $args = explode('/', $val);
    if (count($args) > 1) {
        $res = calculate($args[0]); // начальное значение — первый аргумент
        if (!isnum($res)) return $res;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            if ($arg == 0) return 'Деление на ноль!';
            $res /= $arg;
        }
        return $res;
    }

    // не число, нет ни одного знака операции — значит ошибка
    return 'Недопустимые символы в выражении';
}


// ===== ПРОВЕРКА КОРРЕКТНОСТИ СКОБОК =====
function sqValidator($val)
{
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') $open++;
        else if ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false; // ")" без парной "("
        }
    }
    return ($open === 0); // число открывающих и закрывающих должно совпасть
}


// ===== ВЫЧИСЛЕНИЕ ВЫРАЖЕНИЯ СО СКОБКАМИ (рекурсия) =====
function calculateSq($val)
{
    if (!sqValidator($val)) return 'Неправильная расстановка скобок';

    $start = strpos($val, '('); // первая открывающая скобка
    if ($start === false)
        return calculate($val); // скобок нет — обычное вычисление

    // ищем парную закрывающую скобку
    $end = $start + 1;
    $open = 1;
    while ($open && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        if ($val[$end] == ')') $open--;
        $end++;
    }
    // теперь $end — индекс символа ПОСЛЕ парной ")"

    // вычисляем выражение внутри скобок
    $inner = calculateSq(substr($val, $start + 1, $end - $start - 2));
    if (!isnum($inner)) return $inner; // ошибка внутри скобок

    // собираем новое выражение: левая часть + результат скобок + правая часть
    $new_val = substr($val, 0, $start) . $inner . substr($val, $end);
    return calculateSq($new_val); // вычисляем дальше (убрали одну пару скобок)
}


// ===== ОБРАБОТКА ФОРМЫ =====
$res = null;
if (isset($_POST['val'])) {
    // чистим ввод: убираем пробелы, ":" заменяем на "/"
    $raw = $_POST['val'];
    $clean = '';
    for ($i = 0; $i < strlen($raw); $i++) {
        $c = $raw[$i];
        if ($c == ' ') continue;
        if ($c == ':') $c = '/';
        $clean .= $c;
    }

    if ($clean === '')
        $res = 'Выражение не задано!';
    else
        $res = calculateSq($clean);
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px;
        font-family: Arial, sans-serif;
    }
    .result {
        border: 2px solid #999;
        background: #f9f9f9;
        padding: 12px 20px;
        margin-bottom: 15px;
        font-size: 16px;
        min-width: 300px;
        text-align: center;
    }
    .result.error { color: red; font-weight: bold; }
    .result.ok { color: green; font-weight: bold; }

    form { margin-bottom: 25px; }
    input[type="text"] {
        width: 280px;
        height: 32px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 16px;
        padding: 2px 8px;
    }
    input[type="submit"] {
        height: 38px;
        padding: 0 20px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
    }
    input[type="submit"]:hover { background: #ccc; }

    .history {
        border-top: 2px solid #999;
        padding-top: 10px;
        width: 350px;
        font-size: 14px;
        color: #555;
    }
    .history b { color: black; }
    </style>
</head>
<body>

<?php
// результат выводится ПЕРЕД формой
if ($res !== null) {
    if (isnum($res))
        echo '<div class="result ok">Значение выражения: ' . $res . '</div>';
    else
        echo '<div class="result error">Ошибка: ' . $res . '</div>';
}
?>

<form method="post" action="">
    <input type="text" name="val" placeholder="например: 2+(3*4)-6/2"
           value="<?php if (isset($_POST['val'])) echo htmlspecialchars($_POST['val']); ?>">
    <!-- скрытое поле со счётчиком загрузки — защита от повторного добавления при F5 -->
    <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
    <input type="submit" value="Вычислить">
</form>

<div class="history">
    <b>История вычислений:</b><br>
<?php

// выводим историю (текущий результат сюда пока не попадает)
for ($i = 0; $i < count($_SESSION['history']); $i++)
    echo $_SESSION['history'][$i] . '<br>';

// добавляем текущее вычисление в историю, только если это НЕ обновление (F5).
// при обычной отправке: iteration из формы +1 совпадает с текущим счётчиком сессии
if (isset($_POST['val']) && $_POST['iteration'] + 1 == $_SESSION['iteration'])
    $_SESSION['history'][] = htmlspecialchars($_POST['val']) . ' = ' . $res;

?>
</div>

</body>
</html>
