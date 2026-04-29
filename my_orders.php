<?php
session_start();
include "bdconnect.php";

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != "1") {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["userid"];
$sql = "SELECT * FROM orders WHERE id_user = '$id_user'";
$result = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мои заказы</title>
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
        }
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .order { 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px; 
            background: #fafafa;
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 20px; 
            align-items: center;
        }
        .btn { 
            display: inline-block; 
            padding: 10px 20px; 
            background: hsl(355, 100.00%, 69.20%); 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: rgb(255, 123, 0);
            transform: translateY(-2px);
        }
        h2 {
            color: #333;
        }
        .order p {
            margin: 8px 0;
        }
        .order strong {
            color: hsl(355, 100.00%, 69.20%);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2> Мои заказы</h2>
        <div>
            <a href="profile.php" class="btn"> Профиль</a>
            <a href="gepeg.php" class="btn">Главная</a>
        </div>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($order = mysqli_fetch_assoc($result)): ?>
            <div class="order">
                <p><strong>Заказ #<?= htmlspecialchars($order['order_number']) ?></strong></p>
                <p>Дата: <?= date('d.m.Y H:i', strtotime($order['order_date'])) ?></p>
                <p>Сумма: <?= number_format($order['cost'] * $order['quantity'], 2) ?> ₽</p>
                <p>Статус:  Выполнен</p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align: center; padding: 50px;">У вас пока нет заказов</p>
    <?php endif; ?>
</div>
</body>
</html>