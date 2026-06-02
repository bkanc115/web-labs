<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ввод массива</title>
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px;
        font-family: Arial, sans-serif;
    }
    table { margin-bottom: 10px; }
    td { padding: 3px 6px; font-size: 15px; }
    td input[type="text"] {
        width: 120px;
        height: 28px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 15px;
        padding: 2px 6px;
    }
    select {
        width: 258px;
        height: 32px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 14px;
        margin-bottom: 8px;
    }
    input[type="button"], input[type="submit"] {
        padding: 8px 18px;
        border: 2px solid #999;
        background: #e8e8e8;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        margin-right: 6px;
    }
    input[type="button"]:hover, input[type="submit"]:hover { background: #ccc; }
    </style>
    <script>
    var count = 1; // уже есть element0, следующий будет element1

    function setHTML(element, txt) {
        if (element.innerHTML !== undefined)
            element.innerHTML = txt;
        else {
            var range = document.createRange();
            range.selectNodeContents(element);
            range.deleteContents();
            element.appendChild(range.createContextualFragment(txt));
        }
    }

    function addElement() {
        var t = document.getElementById('elements');
        var index = t.rows.length;
        var row = t.insertRow(index);

        var c1 = row.insertCell(0); // ячейка с номером
        setHTML(c1, count + ':');

        var c2 = row.insertCell(1); // ячейка с полем ввода
        c2.className = 'element_row';
        setHTML(c2, '<input type="text" name="element' + count + '">');

        count++;
        // записываем актуальное количество полей в скрытое поле
        document.getElementById('arrLength').value = count;
    }
    </script>
</head>
<body>

<form method="post" action="sort.php" target="_blank">

    <table id="elements">
        <tr>
            <td>0:</td>
            <td class="element_row"><input type="text" name="element0"></td>
        </tr>
    </table>

    <!-- скрытое поле хранит количество элементов массива -->
    <input type="hidden" id="arrLength" name="arrLength" value="1">

    <select name="algoritm">
        <option value="selection">Сортировка выбором</option>
        <option value="bubble">Пузырьковый алгоритм</option>
        <option value="shell">Алгоритм Шелла</option>
        <option value="gnome">Алгоритм садового гнома</option>
        <option value="quick">Быстрая сортировка</option>
        <option value="builtin">Встроенная функция PHP (sort)</option>
    </select>
    <br>
    <input type="button" value="Добавить еще один элемент" onclick="addElement()">
    <input type="submit" value="Сортировать массив">

</form>

</body>
</html>
