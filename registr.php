<?php
include "bdconnect.php";
if(isset($_POST["reg"])){
    $name=htmlspecialchars($_POST["name"]);
    $login=htmlspecialchars($_POST["login"]);
    $password=htmlspecialchars($_POST["password"]);
    $hash=password_hash($password,PASSWORD_BCRYPT);
    $q=mysqli_query($link,"SELECT * FROM users WHERE login='".$login."'");
    $nq=mysqli_num_rows($q);
    if($nq==0){
    $hasErrors=true;
    $sql="INSERT INTO users (login, hash, name) VALUES ('$login','$hash','$name')";
    $result=mysqli_query($link,$sql);
    $mfq=mysqli_fetch_array($q);
    $_SESSION["logged"] = 1;
    $sql="SELECT max(id) FROM users";
    $result=mysqli_query($link,$sql);
    $mfq=mysqli_fetch_array($q);
    $_SESSION["userid"] = $mfq[0];
    }else {
    echo "<div class='error'>Логин уже занят!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
        label {
            color: white;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input {
            display: block;
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
        <h2>Регистрация</h2>
        <form action="" method="post">
            <label for="login">Логин</label>
            <input type="text" name="login" id="login">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Зарегистрироваться" name="reg">
        </form>
        <div class="links">
            <a href="gepeg.php">На главную</a>
        </div>
        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>