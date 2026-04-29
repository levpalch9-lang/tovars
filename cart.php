<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 147, 147);
            margin: 20px;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
            font-weight: 600;
        }
        .total {
            margin-top: 20px;
            padding-top: 15px;
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            border-top: 2px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: hsl(355, 100.00%, 69.20%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            margin: 10px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: rgb(255, 123, 0);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
        }
        .btn-danger {
            background-color: #f44336;
            padding: 5px 15px;
            font-size: 12px;
        }
        .btn-danger:hover {
            background-color: #da190b;
            transform: translateY(-2px);
        }
        .empty {
            text-align: center;
            padding: 50px;
        }
        .empty h3 {
            color: #666;
            margin-bottom: 15px;
        }
        .cart-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: hsl(355, 100.00%, 69.20%);
            padding: 12px 25px;
            border-radius: 8px;
            z-index: 100;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .cart-fixed:hover {
            background-color: rgb(255, 123, 0);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        a {
            text-decoration: none;
        }
        input[type="number"] {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>

<a href="cart.php" class="cart-fixed">Корзина</a>

<div class="container">
    <h1>Моя корзина</h1>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                while($row = mysqli_fetch_assoc($result)): 
                    $sum = $row['cost'] * $row['quantity'];
                    $total += $sum;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['cost'], 2) ?> ₽</td>
                        <td>
                            <form action="update_cart.php" method="POST">
                                <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
                                <input type="number" name="quantity" value="<?= $row['quantity'] ?>" min="1" style="width: 60px;" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td><?= number_format($sum, 2) ?> ₽</td>
                        <td>
                            <a href="remove_from_cart.php?id=<?= $row['id'] ?>" class="btn btn-danger">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="total">Итого: <?= number_format($total, 2) ?> ₽</div>
        <div class="actions">
            <a href="table_tovars.php" class="btn">Продолжить покупки</a>
            <?php if($total > 0): ?>
                <a href="checkout.php" class="btn" style="background-color: #4CAF50;">Оформить заказ</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="empty">
            <h3>Корзина пуста</h3>
            <p>Добавьте товары на странице каталога</p>
            <a href="table_tovars.php" class="btn">Перейти к товарам</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>