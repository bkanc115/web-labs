<?php 
    date_default_timezone_set('Europe/Moscow');
    $title = 'Долгопяты'; 
?>
<!DOCTYPE html> 
<html>
<head>
    <title><?php echo $title; ?> Шукис Вадим Игоревич 241-353 | ЛР №А-1 "Простейшая программа на PHP. Конвертация статического контента в динамический."</title>
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
  $link = 'page1.php'; $name = 'Ламы'; $current = false;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>

<a href="<?php
  $link = 'page2.php'; $name = 'Тарсиеры'; $current = true;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>

<a href="<?php
  $link = 'page3.php'; $name = 'Квокки'; $current = false;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>
</header>

<h1>Долгопяты</h1>

<h2>О долгопятах</h2>
<p>Долгопяты обитают в тропических лесах Юго-Восточной Азии, на Больших Зондских островах (кроме о. Ява), прежде всего на островах Суматра, Калимантан (Борнео), Сулавеси, на Филиппинах и многих прилегающих островах.</p>

<h2>Больше о долгопятах</h2>
<p>наибольшее внимание во внешнем облике долгопята привлекают большие глаза диаметра до 16 мм, которые обращены вперёд больше, чем у остальных приматов. В пересчёте на человеческий рост глаза долгопятов по размеру соответствуют яблоку. Кроме того, их огромные жёлтые глаза светятся в темноте. Огромный зрачок способен сильно сокращаться. Хорошо развитые лицевые мышцы позволяют животному гримасничать.</p>

<table>
    <?php echo '<tr><td>Рост</td><td>Вес</td><td>Продолжительность жизни</td></tr>'; ?>
    <tr>
        <td><?php echo '8-16см, хвост от 13 до 27см'; ?> </td>
        <td><?php echo 'От 80 до 150г'; ?> </td>
        <td><?php echo 'до 14 лет'; ?> </td>
    </tr>
</table>

<p>В прошлом долгопяты играли большую роль в мифологии и суевериях народов Индонезии. Индонезийцы думали, что головы долгопятов не прикреплены к телу (так как могут вращаться почти на 360°), и опасались встреч с ними, так как верили, что при контакте с этими существами подобная судьба может постичь и человека.</p>

<?php
  if (date('s') % 2 == 0) {
    echo '<img src="photos/tarsier1.jpg" alt="тарсиер">';
  } else {
    echo '<img src="photos/tarsier2.jpg" alt="тарсиер">';
  }
?>

<footer>
    Сформировано <?php echo date('d.m.Y в H:i:s'); ?>
</footer>

</body>