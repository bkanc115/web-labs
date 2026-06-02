<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Шукис Вадим Игоревич | Группа 241-353 | Лабораторная работа А-2</title>
  <link rel="stylesheet" href="styles.css">
</head>

  <body>

  <header>
  <div class="header-inner">
    <img src="photos/mospolytech_logo.png" alt="Логотип Мосполитех">
    <p>Шукис Вадим Игоревич | Группа 241-353 | Лабораторная работа А-2</p>
  </div>
</header>

    <main>
      <?php
      $x        = 1;    // начальное значение x
      $count    = 10;   // сколько раз считаем
      $step     = 1;    // шаг
      $min_stop = -100; // стоп если функция стала меньше этого
      $max_stop = 100;  // стоп если функция стала больше этого
      $type     = 'A';  // тип вывода: A, B, C, D или E

      for ($i = 0; $i < $count; $i++, $x += $step) {
    echo 'f(' . $x . ')=??? <br>';
}
    ?>
    </main>

  

    <footer>
      <p>Тип верстки: A</p>
    </footer>

  </body>

</html>