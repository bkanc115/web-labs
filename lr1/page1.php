<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Moscow');
    $title = 'Ламы'; 
?>
<!DOCTYPE html> 
<html>
<head>
    <title><?php echo $title ; ?> Шукис Вадим Игоревич 241-353 | ЛР №А-1 "Простейшая программа на PHP. Конвертация статического контента в динамический."</title>
<style>
    body {
        margin: 0; /* убрать отступы */
        padding: 70px 20px  54px;
        font-family: sans-serif;
    }

    header {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 56px;
        background: darkgreen;
        color: white;
        display: flex;
        align-items: center;
        padding: 0 20px;
        gap: 24px;
    }

    footer {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 44px;
        background: #333;
        color: #aaa;
        display: flex;
        align-items: center;
        padding: 0 20px;
        font-size: 13px;
    }

a       { color:white; text-decoration:none; }
a:hover {text-decoration: underline; }
.active {color: gold;}

table {border-collapse: collapse; margin: 12px 0; }
td    {border: 1px solid #ccc; padding: 6px 12px; }

img {
  width: 300px;
  height: 200px;     
  object-fit: contain;   
  border-radius: 8px;
  margin-right: 12px;
}
</style>

</head>

<body>

<header>
    <a href="<?php
  $link = 'page1.php'; $name = 'Ламы'; $current = true;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>

<a href="<?php
  $link = 'page2.php'; $name = 'Тарсиеры'; $current = false;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>

<a href="<?php
  $link = 'page3.php'; $name = 'Квокки'; $current = false;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>
</header>

<h1>Ламы</h1>

<h2>О ламах</h2>
<p>Ла́мы (лат. Lama) — наряду с верблюдами один из двух современных родов семейства верблюдовых (Camelidae). Встречаются исключительно в Южной Америке. Отличаются от верблюдов отсутствием горбов и меньшим ростом.</p>

<h2>Ламы и Winamp</h2>
<p>Лама являлась животным-талисманом музыкального проигрывателя «Winamp» — её изображение было на заставке, а издаваемый ламой звук — во вступительной мелодии при запуске; слоган компании звучал как «Winamp, it really whips the llama’s ass».</p>

<table>
    <?php echo '<tr><td>Рост</td><td>Вес</td><td>Продолжительность жизни</td></tr>'; ?>
    <tr>
        <td><?php echo '170-180см'; ?> </td>
        <td><?php echo 'До 150кг'; ?> </td>
        <td><?php echo '15-25 лет'; ?> </td>
    </tr>
</table>

<p>Ламы известны своим спокойным нравом, но могут плеваться в случае раздражения. Интересно, что плевки представляют собой не слюну, а полупереваренную жвачку с неприятным запахом – эффективное средство отпугивания сородичей и назойливых туристов.</p>

<?php 
    if (date('s') % 2 == 0) {
        echo '<img src="photos/llama1.jpg" alt="лама 1">';
    } else {
        echo '<img src="photos/llama2.png" alt="лама 2">';
    }
?>


<footer>
    Сформировано <?php echo date('d.m.Y в H:i:s'); ?>
</footer>

</body>