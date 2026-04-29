<?php
include "bdconnect.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = mysqli_query($link, "SELECT * FROM tovars WHERE id = $id");
$tovar = mysqli_fetch_array($result);
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $cena = (float)$_POST['cena'];
    $kol = (int)$_POST['kol'];
    $srok = mysqli_real_escape_string($link, $_POST['srok']);

    $update_query = "UPDATE tovars SET 
                     name = '$name', 
                     cena = $cena, 
                     kol = $kol, 
                     srok = '$srok' 
                     WHERE id = $id";

    if (mysqli_query($link, $update_query)) {
        $success = "Товар успешно обновлен!";
        $result = mysqli_query($link, "SELECT * FROM tovars WHERE id = $id");
        $tovar = mysqli_fetch_array($result);
    } else {
        $error = "Ошибка при обновлении: " . mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редактирование товара</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: hsl(355, 100.00%, 69.20%);
            box-shadow: 0 0 5px rgba(255, 107, 107, 0.3);
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-primary {
            background-color: hsl(355, 100.00%, 69.20%);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: rgb(255, 0, 200);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }

        .btn-back {
            background-color: hsl(355, 100.00%, 69.20%);
            color: white;
            margin-top: 10px;
            display: inline-block;
        }

        .btn-back:hover {
            background-color:rgb(207, 152, 193);
            transform: translateY(-2px);
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Редактирование товара</h2>

        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Название товара:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($tovar['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Цена (₽):</label>
                <input type="number" name="cena" value="<?= $tovar['cena'] ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Количество (шт):</label>
                <input type="number" name="kol" value="<?= $tovar['kol'] ?>" required>
            </div>

            <div class="form-group">
                <label>Срок годности:</label>
                <input type="text" name="srok" value="<?= htmlspecialchars($tovar['srok']) ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Сохранить изменения</button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="table_tovars.php" class="btn btn-back">Вернуться к списку</a>
        </div>
    </div>
</body>

</html>