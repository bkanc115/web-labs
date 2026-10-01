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
      $x        = 5;      // начальное значение x
      $count    = 4;      // сколько раз считаем: 5, 10, 15, 20
      $step     = 5;      // шаг
      $min_stop = -100000; // стоп если функция стала меньше этого
      $max_stop = 10000;   // стоп если функция стала больше этого
      $type     = 'A';  // тип вывода: A, B, C, D или E

      function calcF($x)
      {
          if ($x <= 10) {
              return 10 * $x - 5;
          }

          if ($x > 10 && $x < 20) {
              return ($x + 3) * pow($x, 2);
          }

          // При x = 25 знаменатель равен нулю.
          if ($x == 25) {
              return null;
          }

          return 3 / ($x - 25) + 2;
      }

      for ($i = 0; $i < $count; $i++, $x += $step) {
          $f = calcF($x);

          if ($f === null) {
              echo 'f(' . $x . ') не определена: деление на ноль<br>';
              break;
          }

          echo 'f(' . $x . ') = ' . round($f, 2) . '<br>';

          if ($f < $min_stop || $f > $max_stop) {
              break;
          }
      }
    ?>
    </main>

  

    <footer>
      <p>Тип верстки: A</p>
    </footer>

  </body>

</html>
