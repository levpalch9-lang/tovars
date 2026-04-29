<?php
$host="localhost";
$user="hhejnrxj";
$pass="F4CjcC";
$dbName="hhejnrxj_m1";

$link = mysqli_connect($host, $user, $pass, $dbName);

if (!$link) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8");
?>