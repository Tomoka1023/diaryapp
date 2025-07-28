<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body id="home-main">
<div class="main-container">
<h2>まさ<span>にっき</span>だよ〜</h2>
<p><a href="post.php">いまの<span>きぶん</span>は〜？</a></p>
<p><a href="calendar.php">カレンダ〜</a></p>
<p><a href="posts.php">これまでの<span>にっき</span></a></p>
<p><a href="logout.php">ログアウト</a></p>
</div>
</body>
</html>