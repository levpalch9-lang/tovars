<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ оформлен</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 147, 147);
            text-align: center;
            padding: 50px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .message {
            background-color: white;
            color: #333;
            padding: 40px;
            border-radius: 12px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .message h1 {
            color: #4CAF50;
            margin: 0 0 20px 0;
        }
        .order-number {
            font-size: 24px;
            font-weight: bold;
            color: hsl(355, 100.00%, 69.20%);
            letter-spacing: 2px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            margin-right: 10px;
            padding: 12px 30px;
            background-color: hsl(355, 100.00%, 69.20%);
            color: white;
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
        p {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="message">
        <h1>Заказ успешно оформлен!</h1>
        <p>Номер заказа: <span class="order-number"><?= htmlspecialchars($order_number ?: 'ORD_' . date('YmdHis')) ?></span></p>
        <p>Спасибо за покупку! Мы свяжемся с вами в ближайшее время.</p>
        <a href="table_tovars.php">Продолжить покупки</a>
        <a href="my_orders.php">Мои заказы</a>
    </div>
</body>
</html>