<?php 
include "bdconnect.php";

$name = $_POST["name"];
$cena = $_POST["cena"];
$kol = $_POST["kol"];
$srok = $_POST["srok"];
$id_cat = $_POST["category"];

$sql = "INSERT INTO tovars (name, id_cat, cena, kol, srok) VALUES ('$name', '$id_cat', '$cena', '$kol', '$srok')";

$result = mysqli_query($link, $sql) or die("Query failed: " . mysqli_error($link));

header("Location: uspex.php?i=1");
exit();
?>