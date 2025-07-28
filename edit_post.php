<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "IDが指定されていません";
    exit;
}

// 投稿の取得
$stmt = $pdo->prepare("SELECT * FROM diary_entries WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user']]);
$entry = $stmt->fetch();

if (!$entry) {
    echo "投稿が見つかりません";
    exit;
}

// 編集内容の保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $emotion = $_POST['emotion'] ?? '';

    $stmt = $pdo->prepare("UPDATE diary_entries SET title = ?, content = ?, emotion = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $content, $emotion, $id, $_SESSION['user']]);

    header("Location: daily_posts.php?date=" . date('Y-m-d', strtotime($entry['created_at'])));
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>にっきのへんしゅう</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
</head>
<body>
<h2><span>にっき</span>のへんしゅ</h2>
<form method="post">
    たいとる: <input type="text" name="title" value="<?= htmlspecialchars($entry['title']) ?>"><br>
    きもち:<br>
    <textarea name="content" rows="5" cols="40"><?= htmlspecialchars($entry['content']) ?></textarea><br>
    きもち<span>（あいこん）</span>:<br>
    <select name="emotion">
        <?php
        $emotions = ["😆️", "😐️", "😌️", "😍️", "😢️", "😞️", "😶️", "😵️"];
        foreach ($emotions as $emo) {
            $selected = ($entry['emotion'] === $emo) ? 'selected' : '';
            echo "<option value=\"$emo\" $selected>$emo</option>";
        }
        ?>
    </select><br><br>
    <button type="submit">ほぞん</button>
</form>
    </body>
    </html>