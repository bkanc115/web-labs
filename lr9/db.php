<?php

// Модуль подключения к базе данных.
// Подключается через require из других модулей, где нужна БД.
// логин/пароль зависят от настроек сервера.

$mysqli = mysqli_connect('MySQL-8.4', 'root', '', 'friends', 3306);

if (mysqli_connect_errno()) {
    echo 'Ошибка подключения к БД: ' . mysqli_connect_error();
    exit();
}

mysqli_set_charset($mysqli, 'utf8');
