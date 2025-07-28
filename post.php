<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $emotion = trim($_POST['emotion'] ?? '');

    $stmt = $pdo->prepare("INSERT INTO diary_entries (user_id, title, content, emotion) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user'], $title, $content, $emotion]);

    header("Location: posts.php");
    exit;
}

// VS16（U+FE0F）を除去
$emotion = preg_replace('/\x{FE0F}/u', '', trim($_POST['emotion'] ?? ''));

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>きょうは？</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body>
<h2><span>にっき</span>をかく</h2>
<form method="post">
    たいとる：<input type="text" name="title"><br>
    きもち<br>
    <textarea name="content" rows="5" cols="40"></textarea><br>
    きもち<span>（あいこん）</span><br>
    <select name="emotion">
        <option value="😆️">😆️ いい日！</option>
        <option value="😐️">😐️ ふつう〜</option>
        <option value="😌️">😌️ ほっこりした</option>
        <option value="😍️">😍️ きゅんとした</option>
        <option value="😢️">😢️ さみしかった</option>
        <option value="😞️">😞️ ちょっと疲れた</option>
        <option value="😶️">😶️ ぼーっとした</option>
        <option value="😵️">😵️ もうムリ〜</option>
    </select><br><br>
    <button type="submit">とうこう</button>
</form>

<p><a href="posts.php">これまでの<span>にっき</span>へ</a></p>
</body>
</html>