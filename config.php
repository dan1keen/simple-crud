<?php
/* Данные для БД (MySQL) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'test_v2');

// Установка соединения
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Проверка соединения с бд
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>