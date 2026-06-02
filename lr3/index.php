<?php
$store = '';

if (isset($_GET['store'])) {
    $store = $_GET['store'];
}

if (isset($_GET['key'])) {
    $store .= $_GET['key'];
}

$count = 0;

if (isset($_GET['count'])) {
    $count = $_GET['count'];
}

if (isset($_GET['key'])) {
    $count = $count + 1;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Виртуальная клавиатура</title>
    <style>
    body {
        display: flex;            /* располагает элементы по правилам flexbox */
        flex-direction: column;   
        align-items: center;      
        margin-top: 50px;         
        font-family: Arial, sans-serif;
    }

    .result {
        width: 290px;
        height: 50px;
        border: 2px solid #999;
        background: white;
        text-align: center;       
        line-height: 50px;        
        font-size: 24px;
        margin-bottom: 5px;
    }

    .row {
        display: flex;            /* кнопки в ряду идут слева направо */
        gap: 4px;                
        margin-bottom: 4px;
    }

    a {
        display: inline-block;    /* чтобы у ссылки можно было задать ширину и высоту */
        width: 55px;
        height: 45px;
        border: 2px solid #999;
        background: #e8e8e8;
        text-align: center;
        line-height: 45px;
        text-decoration: none;    
        color: black;             /* чёрный текст вместо синего */
        font-size: 20px;
        font-weight: bold;
    }

    a:hover {
        background: #ccc;         /* при наведении мыши кнопка темнеет */
    }

    .reset {
        width: 290px;             /* кнопка СБРОС */
    }
    .footer {
    margin-top: 15px;
    font-size: 14px;
    color: #666;
}
</style>
</head>
<body>
    <body>

<div class="result"><?php echo $store; ?></div>

<div class="row">
    <a href="/?key=1&store=<?php echo $store; ?>&count=<?php echo $count; ?>">1</a>
    <a href="/?key=2&store=<?php echo $store; ?>&count=<?php echo $count; ?>">2</a>
    <a href="/?key=3&store=<?php echo $store; ?>&count=<?php echo $count; ?>">3</a>
    <a href="/?key=4&store=<?php echo $store; ?>&count=<?php echo $count; ?>">4</a>
    <a href="/?key=5&store=<?php echo $store; ?>&count=<?php echo $count; ?>">5</a>
</div>
<div class="row">
    <a href="/?key=6&store=<?php echo $store; ?>&count=<?php echo $count; ?>">6</a>
    <a href="/?key=7&store=<?php echo $store; ?>&count=<?php echo $count; ?>">7</a>
    <a href="/?key=8&store=<?php echo $store; ?>&count=<?php echo $count; ?>">8</a>
    <a href="/?key=9&store=<?php echo $store; ?>&count=<?php echo $count; ?>">9</a>
    <a href="/?key=0&store=<?php echo $store; ?>&count=<?php echo $count; ?>">0</a>
</div>

<div class="row">
    <a href="/?count=<?php echo ($count + 1); ?>" class="reset">СБРОС</a>
</div>

<div class="footer"><?php echo "Число нажатий: $count"; ?></div>

</body>

</body>
</html>