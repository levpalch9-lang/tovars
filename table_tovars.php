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
    .filter-form {
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .filter-form select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
        width: 200px;
    }

    .filter-form button {
        padding: 10px 20px;
        background-color: hsl(355, 100.00%, 69.20%);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .filter-form button:hover {
        background-color: rgb(255, 0, 200);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
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

    .btn-detail {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: hsl(355, 100.00%, 69.20%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
        text-align: center;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-detail:hover {
        background-color: rgb(255, 0, 200);
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
        background-color: rgb(255, 0, 200);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
    }

    .cart-form {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .cart-btn {
        display: block;
        margin: 20px auto;
        padding: 15px 40px;
        background-color: #4CAF50;
        font-size: 18px;
    }
    
    .cart-btn:hover {
        background-color: #45a049;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    
    .checkbox-item {
        margin-top: 10px;
        text-align: center;
    }
    
    .checkbox-item label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        font-size: 14px;
        color: #555;
    }
    
    .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
</style>

<?
include "bdconnect.php";
session_start();

function getCategories($link) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($link, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

function show_tovars($link) {
    $category = isset($_POST["category"]) ? $_POST["category"] : (isset($_GET["category"]) ? $_GET["category"] : "Bce");
    
    if($category == "Bce") {
        $sql = "SELECT tovars.*, categories.category 
                FROM tovars 
                LEFT JOIN categories ON tovars.id_cat = categories.id_cat";
    } else {
        $category = mysqli_real_escape_string($link, $category);
        $sql = "SELECT tovars.*, categories.category 
                FROM tovars 
                LEFT JOIN categories ON tovars.id_cat = categories.id_cat 
                WHERE categories.id_cat = '$category'";
    }
    
    $result = mysqli_query($link, $sql) or die("Query failed: " . mysqli_error($link));
    
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="products-grid">';
        
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="tovar">
                <div class="tovar__image">
                     <img src="<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                </div>   
                <h3 class="tovar__name"><?= htmlspecialchars($row['name']) ?></h3>
                <ul>
                    <li><span>Категория:</span> <?= htmlspecialchars($row['category'] ?? 'Без категории') ?></li>
                    <li><span>Цена:</span> <?= htmlspecialchars($row['cena']) ?> ₽</li>
                    <li><span>Количество:</span> <?= htmlspecialchars($row['kol']) ?> шт</li>
                    <li><span>Срок годности:</span> <?= htmlspecialchars($row['srok']) ?></li>
                </ul>
                <a href="card_tovar.php?id=<?= $row['id'] ?>" class="btn-detail">Подробнее</a>
                <div class="checkbox-item">
                    <label>
                        <input type="checkbox" name="tovar_ids[]" value="<?= $row['id'] ?>">
                        Добавить в корзину
                    </label>
                </div>
            </div>    
            <?
        }
        echo '</div>';
    } else {
        echo '<p style="text-align: center; color: #666; padding: 20px;">Товаров в этой категории нет</p>';
    }
}

$categories = getCategories($link);
$selectedCategory = isset($_POST["category"]) ? $_POST["category"] : (isset($_GET["category"]) ? $_GET["category"] : "Bce");
?>

<h3>Список товаров</h3>

<div class="filter-form">
    <form method="POST" action="">
        <select name="category">
            <option value="Bce" <?= $selectedCategory == "Bce" ? "selected" : "" ?>>Все категории</option>
            <? foreach ($categories as $cat): ?>
                <option value="<?= $cat['id_cat'] ?>" <?= $selectedCategory == $cat['id_cat'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($cat['category']) ?>
                </option>
            <? endforeach; ?>
        </select>
        <button type="submit">Фильтровать</button>
    </form>
</div>

<form class="cart-form" method="POST" action="zakaz.php">
    <?
    show_tovars($link);
    ?>
    <input type="submit" class="btn-detail cart-btn" value="Добавить выбранные товары в корзину">
</form>

<a href="gepeg.php">На главную</a>
<a href="cart.php" style="position: fixed; top: 20px; right: 20px; background-color: hsl(355, 100.00%, 69.20%); padding: 12px 25px; border-radius: 8px; z-index: 100; color: white; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"> Корзина</a>