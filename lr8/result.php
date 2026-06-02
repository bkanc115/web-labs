<?php

// анализирует текст и выводит таблицу с информацией
// текст приходит уже перекодированным в CP1251 (1 байт на символ)
function test_it($text)
{
    // массивы-группы символов (ключи — символы в нужной группе)
    $cifra = array('0'=>1,'1'=>1,'2'=>1,'3'=>1,'4'=>1,'5'=>1,'6'=>1,'7'=>1,'8'=>1,'9'=>1);
    $punct = array('.'=>1,','=>1,'!'=>1,'?'=>1,';'=>1,':'=>1,'-'=>1,'('=>1,')'=>1,'"'=>1,"'"=>1);

    $char_count  = strlen($text); // всего символов (с пробелами)
    $letters     = 0;             // букв
    $lower       = 0;             // строчных букв
    $upper       = 0;             // заглавных букв
    $punct_count = 0;             // знаков препинания
    $cifra_count = 0;             // цифр

    $word   = '';        // текущее слово
    $words  = array();   // список слов и количество вхождений

    for ($i = 0; $i < strlen($text); $i++) {
        $c = $text[$i];

        // цифра
        if (array_key_exists($c, $cifra))
            $cifra_count++;

        // знак препинания
        if (array_key_exists($c, $punct))
            $punct_count++;

        // буква: сравниваем символ в нижнем и верхнем регистре
        $is_letter = (strtolower($c) != strtoupper($c));
        if ($is_letter) {
            $letters++;
            if ($c == strtolower($c)) $lower++;
            else $upper++;
        }

        // разбиение на слова: разделитель — пробел, знак препинания или конец текста
        $is_sep = ($c == ' ' || array_key_exists($c, $punct) || $c == "\n" || $c == "\r");

        if ($is_sep || $i == strlen($text) - 1) {
            // если последний символ — буква, добавляем его в слово
            if ($i == strlen($text) - 1 && !$is_sep)
                $word .= $c;
            if ($word) {
                $w = strtolower($word);
                if (isset($words[$w])) $words[$w]++;
                else $words[$w] = 1;
            }
            $word = '';
        } else {
            $word .= $c;
        }
    }

    // ===== ВЫВОД ИНФОРМАЦИИ О ТЕКСТЕ =====
    echo '<table class="info">';
    echo '<tr><td>Количество символов (с пробелами)</td><td>' . $char_count . '</td></tr>';
    echo '<tr><td>Количество букв</td><td>' . $letters . '</td></tr>';
    echo '<tr><td>Строчных букв</td><td>' . $lower . '</td></tr>';
    echo '<tr><td>Заглавных букв</td><td>' . $upper . '</td></tr>';
    echo '<tr><td>Знаков препинания</td><td>' . $punct_count . '</td></tr>';
    echo '<tr><td>Цифр</td><td>' . $cifra_count . '</td></tr>';
    echo '<tr><td>Количество слов</td><td>' . count($words) . '</td></tr>';
    echo '</table>';

    // ===== КОЛИЧЕСТВО ВХОЖДЕНИЙ КАЖДОГО СИМВОЛА =====
    $symbs = test_symbs($text);
    ksort($symbs); // сортируем по символам
    echo '<h3>Вхождения символов (без учёта регистра)</h3>';
    echo '<table class="info">';
    echo '<tr><td><b>Символ</b></td><td><b>Кол-во</b></td></tr>';
    foreach ($symbs as $key => $val) {
        // пробел и перенос строки показываем подписью
        if ($key == ' ') $key = '(пробел)';
        else if ($key == "\n" || $key == "\r") continue;
        // перекодируем символ обратно в UTF-8 перед выводом
        echo '<tr><td>' . iconv('cp1251', 'utf-8', $key) . '</td><td>' . $val . '</td></tr>';
    }
    echo '</table>';

    // ===== СПИСОК СЛОВ ПО АЛФАВИТУ =====
    ksort($words);
    echo '<h3>Слова (по алфавиту)</h3>';
    echo '<table class="info">';
    echo '<tr><td><b>Слово</b></td><td><b>Вхождений</b></td></tr>';
    foreach ($words as $key => $val) {
        echo '<tr><td>' . iconv('cp1251', 'utf-8', $key) . '</td><td>' . $val . '</td></tr>';
    }
    echo '</table>';
}

// возвращает массив символов и количество их вхождений (без учёта регистра)
function test_symbs($text)
{
    $symbs = array();
    $l_text = strtolower($text);
    for ($i = 0; $i < strlen($l_text); $i++) {
        if (isset($symbs[$l_text[$i]]))
            $symbs[$l_text[$i]]++;
        else
            $symbs[$l_text[$i]] = 1;
    }
    return $symbs;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа</title>
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        font-family: Arial, sans-serif;
    }
    .src_text {
        border: 2px solid #999;
        background: #f9f9f9;
        padding: 15px 20px;
        margin-bottom: 15px;
        max-width: 600px;
        color: #0066cc;
        font-style: italic;
        white-space: pre-wrap;
    }
    .src_error {
        border: 2px solid #999;
        background: #f9f9f9;
        padding: 15px 20px;
        margin-bottom: 15px;
        color: red;
        font-weight: bold;
    }
    table.info {
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    table.info td {
        border: 2px solid #999;
        padding: 6px 14px;
        font-size: 14px;
    }
    h3 { margin-bottom: 6px; }
    a.btn {
        display: inline-block;
        padding: 8px 24px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: black;
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
    }
    a.btn:hover { background: #ccc; }
    </style>
</head>
<body>

<?php

if (isset($_POST['data']) && $_POST['data']) {
    // выводим исходный текст (в UTF-8, как пришёл)
    echo '<div class="src_text">' . htmlspecialchars($_POST['data']) . '</div>';
    // перекодируем в CP1251 для корректной работы строковых функций
    test_it(iconv('utf-8', 'cp1251', $_POST['data']));
} else {
    echo '<div class="src_error">Нет текста для анализа</div>';
}

?>

<a class="btn" href="index.html">Другой анализ</a>

</body>
</html>
