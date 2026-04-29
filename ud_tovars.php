<?php 
include "bdconnect.php";   

if(isset($_POST["ud_id"]) && !empty($_POST["ud_id"])) {
    $mass = $_POST["ud_id"];
    foreach($mass as $id) {
        $id = intval($id);
        $sql = "DELETE FROM tovars WHERE id=$id";
        $result = mysqli_query($link, $sql) or die("Query failed");
    }
    header("Location: uspex.php?i=2");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление товарами</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto 30px auto;
            padding: 0 15px;
        }

        .tovar {
            background: white;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: left;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
        }

        .tovar:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .tovar__image {
            width: 100%;
            height: 200px;
            background-color: rgb(255, 147, 147);
            overflow: hidden;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .tovar__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .tovar__name {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px 0;
            color: #1a1a1a;
        }

        .tovar ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            flex-grow: 1;
        }

        .tovar li {
            padding: 6px 0;
            font-size: 14px;
            color: #555;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
        }

        .tovar li:last-child {
            border-bottom: none;
        }

        .tovar li span {
            font-weight: 600;
            color: #333;
        }

        .delete-label {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            color: #d9534f;
            font-weight: bold;
        }
        
        .delete-label input {
            margin: 0;
            transform: scale(1.5);
            cursor: pointer;
        }


        a, input[type="submit"] {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: hsl(355, 100.00%, 69.20%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        a:hover, input[type="submit"]:hover {
            background-color: rgb(255, 123, 0);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
        }
    </style>
</head>
<body>

    <h3>Список товаров для удаления</h3>

        <div class="products-grid">
            <?php 
            $result = mysqli_query($link, "SELECT * FROM tovars");
            
            if ($result && mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $id = $row['id'];
                    ?>
                    <div class="tovar">
                        <div class="tovar__image">     
                            <span style="color:white; font-weight:bold;"></span>
                        </div>   
                        <h3 class="tovar__name"><?= htmlspecialchars($row['name']) ?></h3>   
                        <ul>
                            <li><span>ID:</span> <?= htmlspecialchars($row['id']) ?></li>
                            <li><span>Цена:</span> <?= htmlspecialchars($row['cena']) ?> ₽</li>
                            <li><span>Количество:</span> <?= htmlspecialchars($row['kol']) ?> шт</li>
                            <li><span>Срок:</span> <?= htmlspecialchars($row['srok']) ?></li>
                            <li>
                                <span>Удалить:</span>
                                <label class="delete-label">
                                    <input type="checkbox" name="ud_id[]" value="<?= $id ?>">
                                </label>
                                
                              
                            </li>
                        <li>  <a href ="update.php?id=<? echo $id ?>">Редактировать</a></li>
                        </ul>
                    </div>    
                    <?php
                }
            } else {
                echo '<p style="grid-column: 1/-1;">Товаров пока нет</p>';
            }
            ?>
        </div>
</td><td></td>
<input type=checkbox name=ud_id[] value="<? echo $id ?>">
<? echo "</td>
</tr>";
        ?>
        <input type="submit" name="ud" value="Удалить выбранные">
    </form>

    <a href="gepeg.php">На главную</a>

</body>
</html>