<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Склад товаров</title>
</head>
<style>
    body {
        background-color: rgb(255, 147, 147);
        align-items: center;
        justify-content: center;
    }
    input[type="submit"] {
        display: inline-block;
        width: 100%;
        margin-top: 10px;
        padding: 12px 30px;
        background-color: white;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: rgb(255, 123, 0);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
    }
    a {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 30px;
        background-color: white;
        color: black;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    a:hover {
        background-color: rgb(255, 123, 0);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
    }
    .container{
        width: 80%;          
        max-width: 400px;   
        margin: 0 auto; 
    }
</style>
<body>
    <div class="container">
    <h1>Список товаров</h1>
    <? include "tovars.php"; ?>
    <br>
    <a href="vvod_tovars.php">Добавить товар</a><br>
    <a href="ud_tovars.php">Удалить/Редактировать товар</a><br>
    <a href="table_tovars.php">Посмотреть в виде таблицы</a><br>
    <a href="registr.php">Форма регистрации</a><br>
    <a href="login.php">Авторизация</a><br>
    <a href="cart.php" style="position: fixed; top: 20px; right: 20px; background-color: hsl(355, 100.00%, 69.20%); padding: 12px 25px; border-radius: 8px; color: white; text-decoration: none; font-weight: 600;"> Корзина</a>
    </div>
</body>
</html>