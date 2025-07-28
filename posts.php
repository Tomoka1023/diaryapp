<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM diary_entries WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user']]);
$entries = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>これまでのにっき</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body>
<h2>これまでの<span>にっき</span></h2>
<p><a href="post.php">あたらしい<span>にっき</span>をかく</a> or <a href="home.php"><span>ほーむ</span>へ</a></p>

<?php foreach ($entries as $entry): ?>
    <?php
        $date = date('Y-m-d', strtotime($entry['created_at']));
    ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0; background-color: #fdd5f9;">
    <a href="daily_posts.php?date=<?= $date ?>" style="text-decoration: none; color: inherit;">
        <strong><?= htmlspecialchars($entry['emotion']) ?></strong><br>
        <small><?= htmlspecialchars($entry['created_at']) ?></small><br>
    </a>
        <p><?= nl2br(htmlspecialchars($entry['content'])) ?></p>
    </div>
<?php endforeach; ?>
</body>
</html>