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
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .product-card {
        max-width: 600px;
        margin: 50px auto;
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        text-align: left;
    }

    .product-card h2 {
        color: #333;
        margin-top: 0;
        font-size: 28px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .product-info {
        margin: 20px 0;
    }

    .product-info p {
        font-size: 18px;
        padding: 10px 0;
        margin: 0;
        border-bottom: 1px solid #eee;
    }

    .product-info p:last-child {
        border-bottom: none;
    }

    .product-info strong {
        display: inline-block;
        width: 150px;
        color: #555;
    }

    .price {
        font-size: 24px;
        color: hsl(355, 100.00%, 69.20%);
        font-weight: bold;
    }

    .btn-back {
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
    }

    .btn-back:hover {
        background-color: rgb(255, 123, 0);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
    }

    .error {
        color: #666;
        font-size: 18px;
        text-align: center;
        padding: 40px;
    }
</style>

<?
include "bdconnect.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $result = mysqli_query($link, "SELECT * FROM tovars WHERE id = $id");
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        ?>
        <div class="product-card">
            <h2><?= htmlspecialchars($row['name']) ?></h2>
            
            <div class="product-info">
                <p><strong>Цена:</strong> <span class="price"><?= htmlspecialchars($row['cena']) ?> ₽</span></p>
                <p><strong>Количество на складе:</strong> <?= htmlspecialchars($row['kol']) ?> шт</p>
                <p><strong>Срок годности:</strong> <?= htmlspecialchars($row['srok']) ?></p>
                
                <?php if (!empty($row['description'])): ?>
                    <p><strong>Описание:</strong><br> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($row['brand'])): ?>
                    <p><strong>Бренд:</strong> <?= htmlspecialchars($row['brand']) ?></p>
                <?php endif; ?>
            </div>
            
            <a href="javascript:history.back()" class="btn-back">← Вернуться к списку</a>
        </div>
        <?
    } else {
        echo '<div class="error">Товар не найден</div>';
        echo '<a href="table_tovars.php" class="btn-back">← Вернуться к списку</a>';
    }
} else {
    echo '<div class="error">Не указан ID товара</div>';
    echo '<a href="table_tovars.php" class="btn-back">← Вернуться к списку</a>';
}
?>