<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// 表示する月（指定がなければ今月）
$year = isset($_GET['y']) ? intval($_GET['y']) : date('Y');
$month = isset($_GET['m']) ? intval($_GET['m']) : date('n');

// 該当月の全投稿を取得
$stmt = $pdo->prepare("SELECT DATE(created_at) AS date,
                              SUBSTRING_INDEX(GROUP_CONCAT(emotion ORDER BY created_at DESC), ',', 1) AS emotion
                       FROM diary_entries
                       WHERE user_id = ? AND YEAR(created_at) = ? AND MONTH(created_at) = ?
                       GROUP BY DATE(created_at)");
$stmt->execute([$_SESSION['user'], $year, $month]);
$emotions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$first_day = mktime(0, 0, 0, $month, 1, $year);
$title = date('Y年n月', $first_day);
$start_week = date('w', $first_day);
$days_in_month = date('t', $first_day);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>カレンダ〜</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Hachi+Maru+Pop&family=Kaisei+Decol&family=M+PLUS+Rounded+1c&family=Yomogi&display=swap" rel="stylesheet">
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 500px; background-color:rgb(255, 249, 254);}
        th, td { border: 1px solid #555; width: 14%; height: 60px; text-align: center; font-size: 1.2em; }
        th { background-color:rgb(252, 188, 251); color:rgb(255, 251, 255);}
    </style>
</head>
<body>
    <h2><?= htmlspecialchars($title) ?>のカレンダ〜</h2>
    <p>
        <a href="?y=<?= $year ?>&m=<?= $month - 1 ?>">←まえのつき</a> |
        <a href="?y=<?= $year ?>&m=<?= $month + 1 ?>">つぎのつき→</a>
    </p>

    <table>
        <tr>
            <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
        </tr>
        <tr>
        <?php
        // 空白セルを先に出す
        for ($i = 0; $i < $start_week; $i++) echo '<td></td>';

        // 各日表示
        for ($day = 1; $day <= $days_in_month; $day++) {
            $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $emotion = $emotions[$date_str] ?? '';
            $link = "daily_posts.php?date=" . urlencode($date_str);
            echo "<td><a href=\"$link\">$day<br>$emotion</a></td>";

            if (($day + $start_week) % 7 === 0) echo '</tr><tr>';
        }

        // 空白セルで調整
        $last = ($days_in_month + $start_week) % 7;
        if ($last !== 0) {
            for ($i = $last; $i < 7; $i++) echo '<td></td>';
        }
        ?>
        </tr>
    </table>

    <p><a href="home.php"><span>ほーむ</span>にもどる</a></p>
</body>
</html>
