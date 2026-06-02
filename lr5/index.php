<?php

$html_type = '';
if (isset($_GET['html_type'])) {
    $html_type = $_GET['html_type'];
}

$content = 0;
if (isset($_GET['content'])) {
    $content = $_GET['content'];
}

// число в ссылку (2-9), остальные — просто текст
// ссылки сбрасывают тип верстки (не передают html_type)
function outNumAsLink($x)
{
    if ($x >= 2 && $x <= 9) {
        return '<a href="?content=' . $x . '">' . $x . '</a>';
    }
    return $x;
}

// столбец таблицы умножения на $n
function outRow($n)
{
    for ($i = 2; $i <= 9; $i++) {
        echo outNumAsLink($n) . ' &times; ' . outNumAsLink($i) . ' = ' . outNumAsLink($i * $n) . '<br>';
    }
}

// вся таблица или один столбец — табличная верстка
function outTableForm()
{
    if (!isset($_GET['content'])) {
        echo '<table class="mult"><tr>';
        for ($i = 2; $i <= 9; $i++) {
            echo '<td>';
            outRow($i);
            echo '</td>';
        }
        echo '</tr></table>';
    } else {
        echo '<table class="mult single"><tr><td>';
        outRow($_GET['content']);
        echo '</td></tr></table>';
    }
}

// вся таблица или один столбец — блочная верстка
function outDivForm()
{
    if (!isset($_GET['content'])) {
        echo '<div class="mult-wrap">';
        for ($i = 2; $i <= 9; $i++) {
            echo '<div class="ttRow">';
            outRow($i);
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="mult-wrap"><div class="ttSingleRow">';
        outRow($_GET['content']);
        echo '</div></div>';
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблица умножения</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    #main_menu {
        display: flex;
        gap: 4px;
        padding: 10px;
        background: #333;
    }
    #main_menu a {
        display: inline-block;
        padding: 8px 20px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: black;
        font-size: 16px;
        font-weight: bold;
    }
    #main_menu a:hover { background: #ccc; }
    #main_menu a.selected { background: #999; color: white; }

    .wrapper {
        display: flex;
        min-height: 80vh;
    }

    #side_menu {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 10px;
        background: #ddd;
    }
    #side_menu a {
        display: block;
        padding: 8px 12px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-decoration: none;
        color: black;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
    }
    #side_menu a:hover { background: #ccc; }
    #side_menu a.selected { background: #999; color: white; }

    .content {
        flex: 1;
        padding: 20px;
    }
    .content a { color: #0066cc; }
    .content a:hover { color: red; }

    table.mult { border-collapse: collapse; }
    table.mult td {
        border: 2px solid #999;
        padding: 10px 14px;
        vertical-align: top;
        font-size: 14px;
        line-height: 1.8;
    }
    table.mult.single td { font-size: 22px; }

    .mult-wrap { display: flex; flex-wrap: wrap; gap: 4px; }
    .ttRow {
        border: 2px solid #999;
        padding: 10px 14px;
        font-size: 14px;
        line-height: 1.8;
    }
    .ttSingleRow {
        border: 2px solid #999;
        padding: 10px 14px;
        font-size: 22px;
        line-height: 1.8;
    }

    .footer {
        padding: 10px;
        background: #333;
        color: #ccc;
        font-size: 14px;
        text-align: center;
    }
    </style>
</head>
<body>

<div id="main_menu"><?php

    // ссылка «Табличная верстка»
    echo '<a href="?html_type=TABLE';
    if (isset($_GET['content']))
        echo '&content=' . $_GET['content'];
    echo '"';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE')
        echo ' class="selected"';
    echo '>Табличная верстка</a>';

    // ссылка «Блочная верстка»
    echo '<a href="?html_type=DIV';
    if (isset($_GET['content']))
        echo '&content=' . $_GET['content'];
    echo '"';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV')
        echo ' class="selected"';
    echo '>Блочная верстка</a>';

?></div>

<div class="wrapper">

    <div id="side_menu"><?php

        // базовая часть ссылки — сохраняем html_type если он есть
        $link = '?';
        if (isset($_GET['html_type']))
            $link = '?html_type=' . $_GET['html_type'] . '&';

        // пункт «Всё»
        echo '<a href="' . $link . '"';
        if (!isset($_GET['content']))
            echo ' class="selected"';
        echo '>Всё</a>';

        // пункты 2–9
        for ($i = 2; $i <= 9; $i++) {
            echo '<a href="' . $link . 'content=' . $i . '"';
            if (isset($_GET['content']) && $_GET['content'] == $i)
                echo ' class="selected"';
            echo '>' . $i . '</a>';
        }

    ?></div>

    <div class="content"><?php

        // по умолчанию и TABLE — табличная, DIV — блочная
        if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE')
            outTableForm();
        else
            outDivForm();

    ?></div>

</div>

<div class="footer"><?php

    if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE')
        $s = 'Табличная верстка. ';
    else
        $s = 'Блочная верстка. ';

    if (!isset($_GET['content']))
        $s .= 'Таблица умножения полностью. ';
    else
        $s .= 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';

    echo $s . date('d.m.Y H:i:s');

?></div>

</body>
</html>
