<?php 
$i = isset($_GET["i"]) ? $_GET["i"] : 0;
$count = isset($_GET["count"]) ? $_GET["count"] : 0;
$st = "";

if($i == 1) $st = "Товар успешно добавлен!";
if($i == 2) $st = "Записи успешно удалены!";
if($i == 3) $st = " Записи успешно обновлены!";
if($i == 4) $st = "Товаров добавлено в корзину: " . $count;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Результат</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: Arial, sans-serif; 
            background: rgb(255, 147, 147); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }
        .message { 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            text-align: center; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .message h3 {
            color: #333;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
<div class="message">
    <h3><?= $st ?></h3>
    <a href="table_tovars.php" class="btn">Продолжить покупки</a>
    <a href="cart.php" class="btn"> Перейти в корзину</a>
</div>
</body>
</html>