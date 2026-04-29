<?php
session_start();
    include("bdconnect.php");
  //  if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="1")
  //      header("Location: profile.php");
    if(isset($_POST["auth"])){
        
        $login=$_POST["login"];
        $password=$_POST["password"];
        $dataSent=$_POST["dataSent"];
        $hasErrors=false;
        if($dataSent==1){
            $q=mysqli_query($link,"SELECT * FROM users WHERE login='".$login."'");
        
            $nq=mysqli_num_rows($q);
            
            if($nq==0){
                $hasErrors=true;
            }elseif($nq==1){
                $mfq=mysqli_fetch_array($q);
                $hash=$mfq["hash"];
                if(password_verify($password, $hash)){
                    $_SESSION["logged"] = 1;
                    $_SESSION["userid"] = $mfq[0];
                    
                    header("Location: profile.php");
                }
            }
            else $hasErrors=true;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Вход на сайт</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(255, 147, 147);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .container {
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            display: block;
            margin-top: 15px;
            padding: 12px 15px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }
        input:focus {
            box-shadow: 0 0 5px rgb(255, 123, 0);
        }
        input[type="submit"] {
            margin-top: 25px;
            background-color: white;
            color: black;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: rgb(255, 123, 0);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: white;
            color: black;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-align: center;
        }
        a:hover {
            background-color: rgb(255, 123, 0);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 195, 255, 0.3);
        }
        .error {
            color: yellow;
            margin-top: 15px;
            text-align: center;
        }
        h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
        .links {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Вход на сайт</h2>
    <form method="POST">
        <input type="text" name="login" placeholder="Логин"/>
        <input type="password" name="password" placeholder="Пароль"/>
        <input type="hidden" name="dataSent" value="1"/>
        <input type="submit" value="Войти" name="auth" >
    </form>
    <?php
    if($hasErrors){
        echo "<div class='error'>Вы ввели неправильный логин или пароль</div>";
    }
    ?>
    <div class="links">
        <a href="registr.php">Регистрация</a>
        <a href="gepeg.php">На главную</a>
    </div>
</div>
</body>
</html>