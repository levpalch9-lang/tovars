<?php
session_start();
include "bdconnect.php";

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != "1") {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["userid"];
$user_query = mysqli_query($link, "SELECT * FROM users WHERE id = '$id_user'");
$user = mysqli_fetch_assoc($user_query);

$orders_count = mysqli_num_rows(mysqli_query($link, "SELECT * FROM orders WHERE id_user = '$id_user'"));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: Arial, sans-serif; 
            background: rgb(255, 147, 147); 
            margin: 20px; 
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            text-align: center; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .btn { 
            display: inline-block; 
            padding: 10px 20px; 
            background: hsl(355, 100.00%, 69.20%); 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 10px; 
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: rgb(255, 123, 0);
            transform: translateY(-2px);
        }
        .btn-danger { 
            background: #dc3545; 
        }
        .btn-danger:hover {
            background: #c82333;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            margin: 15px 0;
            font-size: 16px;
            color: #555;
        }
        p strong {
            color: hsl(355, 100.00%, 69.20%);
        }
    </style>
</head>
<body>
<div class="container">
    <h2> Личный кабинет</h2>
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Логин:</strong> <?= htmlspecialchars($user['login']) ?></p>
    <p><strong>Всего заказов:</strong> <?= $orders_count ?></p>
    
    <a href="my_orders.php" class="btn"> Мои заказы</a>
    <a href="cart.php" class="btn">Корзина</a>
    <a href="gepeg.php" class="btn"> Главная</a>
    <a href="logout.php" class="btn btn-danger"> Выйти</a>
</div>
</body>
</html>