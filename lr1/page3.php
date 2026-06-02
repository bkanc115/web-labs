<?php
    date_default_timezone_set('Europe/Moscow');
    $title = 'Квокки'; 
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
  $link = 'page2.php'; $name = 'Тарсиеры'; $current = false;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>

<a href="<?php
  $link = 'page3.php'; $name = 'Квокки'; $current = true;
  echo $link;
?>" <?php if($current) echo 'class="active"'; ?>><?php echo $name; ?></a>
</header>

<h1>Квокки</h1>

<h2>О квокках</h2>
<p>Квокка, или Короткохвостый кенгуру (лат. Setonix brachyurus), — единственный представитель рода Setonix семейства кенгуровых. </p>

<h2>Ещё немного о квокках</h2>
<p>В связи с отсуствием хищников в местах обитания, квокки очень любопытны и не боятся человека, часто подпускают его вплотную. Характерной чертой является «улыбка» на морде, которая появляется при расслаблении челюстных мышц, когда зверёк перестаёт жевать</p>

<table>
    <?php echo '<tr><td>Рост</td><td>Вес</td><td>Продолжительность жизни</td></tr>'; ?>
    <tr>
        <td><?php echo '47-50см'; ?> </td>
        <td><?php echo 'до 5кг'; ?> </td>
        <td><?php echo 'до 10 лет'; ?> </td>
    </tr>
</table>

<p>Квокка относится к уязвимым видам. Расширение сельскохозяйственных угодий привело к уменьшению естественной среды обитания и, как следствие, к сокращению численности данного вида. Разведение кошек и собак, а также осушение болот усугубляют эту проблему</p>

<?php
  if (date('s') % 2 == 0) {
    echo '<img src="photos/quokka1.jpg" alt="квокка">';
  } else {
    echo '<img src="photos/quokka2.jpg" alt="квокка">';
  }
?>

<footer>
    Сформировано <?php echo date('d.m.Y в H:i:s'); ?>
</footer>

</body>