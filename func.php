<?php
function show_categories(){
    include "bdconnect.php";
    $sql="SELECT * FROM categories";
    $result = mysqli_query($link,$sql) or die("Query failed");
    $array_category = array();
    while($row=mysqli_fetch_array($result)){
        $array_category[$row["id_cat"]]=$row["category"];
    };
    $str="";
    foreach($array_category as $key => $value){
        $str=$str."<option value='".$key."'>".$value."</option>";
    }
    return $str;
}

function getCategories($link) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($link, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}
?>