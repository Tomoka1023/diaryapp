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

// 削除処理
$stmt = $pdo->prepare("DELETE FROM diary_entries WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user']]);

header("Location: calendar.php");
exit;
?>