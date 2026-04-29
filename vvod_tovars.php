<?
include "func.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Склад товаров -> Добавление товара</title>
    <style>
        body {
            background-color: #f4f4f4;
            margin: 20px;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-container {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;

            font-size: 14px;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: hsl(355, 100.00%, 69.20%);
        }

        input[type="submit"] {
            display: inline-block;
            width: 100%;
            margin-top: 10px;
            padding: 12px 30px;
            background-color: hsl(355, 100.00%, 69.20%);
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
    </style>
</head>
<body>

    <h3>Добавление товара</h3>

    <div class="form-container">
        <form action="insert_tovars.php" method="post" name="form1">
            
            <div class="form-group">
                <label for="name">Название товара</label>
                <input type="text" id="name" name="name" required/>
            </div>

            <div class="form-group">
                <label for="category">Категория товара</label>
                <select name="category" id="category">
                    <?
                    echo show_categories();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cena">Цена товара</label>
                <input type="number" id="cena" name="cena" required/>
            </div>

            <div class="form-group">
                <label for="kol">Количество</label>
                <input type="text" id="kol" name="kol" required/>
            </div>

            <div class="form-group">
                <label for="srok">Срок годности</label>
                <input type="date" id="srok" name="srok" required/>
            </div>

            <input type="submit" name="insert" value="Добавить">
        </form>
    </div>

    <br>
    <a href="gepeg.php">На главную</a>

</body>
</html>