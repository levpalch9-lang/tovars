<?php
session_start();
include "bdconnect.php";

date_default_timezone_set('Europe/Moscow');

if(isset($_POST["tovar_ids"]) && is_array($_POST["tovar_ids"])) {
    $tovar_ids = $_POST["tovar_ids"];
    

    if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="1") {
        $id_user = $_SESSION["userid"];
    } else {
        if(!isset($_SESSION['temp_user_id'])) {
            $_SESSION['temp_user_id'] = session_id();
        }
        $id_user = $_SESSION['temp_user_id'];
    }
    
    $data = date("Y-m-d H:i:s");
    $id_order = time();
    $success_count = 0;
    
    foreach($tovar_ids as $tovar_id) {
        $tovar_id = (int)$tovar_id;
        $sql_tovar = "SELECT * FROM tovars WHERE id = $tovar_id";
        $result_tovar = mysqli_query($link, $sql_tovar);
        
        if($row_tovar = mysqli_fetch_assoc($result_tovar)) {
            $cena = $row_tovar['cena'];
            $quantity = 1;
            
            $sql = "INSERT INTO orders (id_order, id_user, id_tovar, quantity, cost, datatime) 
                    VALUES ('$id_order', '$id_user', $tovar_id, $quantity, $cena, '$data')";
            
            if(mysqli_query($link, $sql)) {
                $success_count++;
            }
        }
    }
    
    header("Location: uspex.php?i=4&count=" . $success_count);
    exit();
} else {
    header("Location: table_tovars.php?error=no_items");
    exit();
}
?>