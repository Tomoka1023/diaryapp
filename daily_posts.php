<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$date = $_GET['date'] ?? '';
if (!$date) {
    echo "日付が指定されていません";
    exit;
}

// 指定日の投稿を取得
$stmt = $pdo->prepare("SELECT * FROM diary_entries WHERE user_id = ? AND DATE(created_at) = ?");
$stmt->execute([$_SESSION['user'], $date]);
$entries = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= htmlspecialchars($date) ?>のにっき</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body>
<h2><?= htmlspecialchars($date) ?> の<span>にっき</span></h2>
<p><a href="calendar.php">← <span>カレンダ〜</span>にもどる</a></p>

<?php if (empty($entries)): ?>
    <p>なにもないよ。</p>
<?php else: ?>
    <?php foreach ($entries as $entry): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: #fdd5f9;">
            <strong><?= htmlspecialchars($entry['title']) ?> <?= $entry['emotion'] ?></strong><br>
            <small><?= htmlspecialchars($entry['created_at']) ?></small><br>
            <p><?= nl2br(htmlspecialchars($entry['content'])) ?></p>
            <a href="edit_post.php?id=<?= $entry['id'] ?>">へんしゅ</a> or
            <a href="delete_post.php?id=<?= $entry['id'] ?>" onclick="return confirm('ほんとにけす？');">けす？</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>