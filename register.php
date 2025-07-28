<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $pass = $_POST['password'] ?? '';
    if ($name && $pass) {
        $stmt = $pdo->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
        $stmt->execute([$name, password_hash($pass, PASSWORD_DEFAULT)]);
        $_SESSION['user'] = $pdo->lastInsertId();
        header("Location: home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>ゆーざーとうろく</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body>
<form method="post">
    <h2>ゆーざー<span>とうろく</span></h2>
    なまえ: <input type="text" name="name"><br>
    ぱすわーど: <input type="password" name="password"><br>
    <button type="submit">とうろく</button>
</form>
<p><a href="login.php">ログイン</a></p>
</body>
</html>