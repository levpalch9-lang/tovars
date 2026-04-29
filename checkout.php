<?php
session_start();
include "bdconnect.php";

if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="1" && isset($_SESSION["userid"])) {
    $id_user = $_SESSION["userid"];
    $user_query = mysqli_query($link, "SELECT * FROM users WHERE id = '$id_user'");
    $user_data = mysqli_fetch_assoc($user_query);
} else {
    if(!isset($_SESSION['temp_user_id'])) {
        $_SESSION['temp_user_id'] = session_id();
    }
    $id_user = $_SESSION['temp_user_id'];
    $user_data = null;
}

$sql = "SELECT o.*, t.name, t.kol as stock_quantity 
        FROM orders o 
        LEFT JOIN tovars t ON o.id_tovar = t.id 
        WHERE o.id_user = '$id_user'
        ORDER BY o.datatime DESC";
$result = mysqli_query($link, $sql);

$cart_items = [];
$total = 0;
while($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $total += $row['cost'] * $row['quantity'];
}

if(isset($_POST['place_order'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $address = mysqli_real_escape_string($link, $_POST['address']);
    $comment = mysqli_real_escape_string($link, $_POST['comment']);
    $payment_method = mysqli_real_escape_string($link, $_POST['payment_method']);
    
    $order_date = date("Y-m-d H:i:s");
    $order_number = "ORD_" . time() . "_" . rand(1000, 9999);
    
    $stock_error = false;
    foreach($cart_items as $item) {
        if($item['quantity'] > $item['stock_quantity']) {
            $stock_error = true;
            $error = "Товара '{$item['name']}' недостаточно на складе. Доступно: {$item['stock_quantity']} шт.";
            break;
        }
    }
    
    if(!$stock_error) {
        $update_sql = "UPDATE orders SET 
                       customer_name = '$name',
                       customer_phone = '$phone',
                       delivery_address = '$address',
                       comment = '$comment',
                       payment_method = '$payment_method',
                       order_number = '$order_number',
                       order_date = '$order_date',
                       status = 'completed'
                       WHERE id_user = '$id_user'";
        
        if(mysqli_query($link, $update_sql)) {
            foreach($cart_items as $item) {
                $new_quantity = $item['stock_quantity'] - $item['quantity'];
                mysqli_query($link, "UPDATE tovars SET kol = $new_quantity WHERE id = {$item['id_tovar']}");
            }
            
            $_SESSION['last_order'] = $order_number;
            header("Location: order_success.php");
            exit();
        } else {
            $error = "Ошибка при оформлении заказа: " . mysqli_error($link);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(255, 147, 147);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            border-radius: 15px;
            padding: 15px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: hsl(355, 100.00%, 69.20%);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            background: hsl(355, 100.00%, 69.20%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgb(255, 123, 0);
            transform: translateY(-2px);
        }

        .checkout-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 30px;
        }

        .cart-summary, .order-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-info h4 {
            color: #333;
            margin-bottom: 5px;
        }

        .cart-item-info p {
            color: #666;
            font-size: 14px;
        }

        .cart-item-price .price {
            font-size: 18px;
            font-weight: bold;
            color: hsl(355, 100.00%, 69.20%);
        }

        .total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            text-align: right;
            font-size: 20px;
        }

        .total span {
            color: hsl(355, 100.00%, 69.20%);
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: hsl(355, 100.00%, 69.20%);
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .payment-method {
            flex: 1;
            position: relative;
        }

        .payment-method input {
            position: absolute;
            opacity: 0;
        }

        .payment-method label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
        }

        .payment-method input:checked + label {
            border-color: hsl(355, 100.00%, 69.20%);
            background: #fff0f0;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: hsl(355, 100.00%, 69.20%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: rgb(255, 123, 0);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 123, 0, 0.4);
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
        }

        .empty-cart a {
            display: inline-block;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .checkout-wrapper {
                grid-template-columns: 1fr;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">Мой Магазин</div>
        <div class="user-info">
            <?php if(isset($_SESSION["logged"]) && $_SESSION["logged"] == "1"): ?>
                <span class="user-name"><?= htmlspecialchars($user_data['name'] ?? 'Пользователь') ?></span>
                <a href="profile.php" class="nav-link">Профиль</a>
                <a href="my_orders.php" class="nav-link">Мои заказы</a>
                <a href="logout.php" class="nav-link">Выйти</a>
            <?php else: ?>
                <span class="user-name">Гость</span>
                <a href="login.php" class="nav-link">Войти</a>
            <?php endif; ?>
            <a href="cart.php" class="nav-link">Корзина</a>
            <a href="gepeg.php" class="nav-link">Главная</a>
        </div>
    </div>

    <div class="checkout-wrapper">
        <div class="cart-summary">
            <h2>Ваш заказ</h2>
            <?php if(count($cart_items) > 0): ?>
                <?php foreach($cart_items as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h4><?= htmlspecialchars($item['name']) ?></h4>
                            <p><?= $item['quantity'] ?> шт x <?= number_format($item['cost'], 2) ?> ₽</p>
                        </div>
                        <div class="cart-item-price">
                            <div class="price"><?= number_format($item['cost'] * $item['quantity'], 2) ?> ₽</div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="total">
                    <strong>Итого: </strong><span><?= number_format($total, 2) ?> ₽</span>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Корзина пуста</p>
                    <a href="table_tovars.php" class="nav-link">Перейти к товарам</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="order-form">
            <h2>Данные для доставки</h2>
            <?php if(isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if(count($cart_items) > 0): ?>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Ваше имя *</label>
                            <input type="text" name="name" required value="<?= htmlspecialchars($user_data['name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Телефон *</label>
                            <input type="tel" name="phone" required placeholder="+7 (XXX) XXX-XX-XX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Адрес доставки *</label>
                        <input type="text" name="address" required placeholder="Город, улица, дом, квартира">
                    </div>

                    <div class="form-group">
                        <label>Комментарий к заказу</label>
                        <textarea name="comment" rows="3" placeholder="Пожелания по доставке, удобное время..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Способ оплаты *</label>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="cash" value="cash" checked>
                                <label for="cash">Наличными</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="card" value="card">
                                <label for="card">Картой онлайн</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="sbp" value="sbp">
                                <label for="sbp">СБП</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="place_order" class="btn-submit">Подтвердить заказ</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>