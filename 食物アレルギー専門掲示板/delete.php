<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: kanri.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    file_put_contents('keijiban.txt', ''); // 投稿内容を空にする
    echo "投稿内容が削除されました。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板管理 - 投稿削除</title>
</head>
<body>
    <h1>掲示板管理</h1>
    <p>掲示板の投稿を削除しますか？</p>
    <form action="delete.php" method="post">
        <input type="hidden" name="delete" value="true">
        <input type="submit" value="削除する">
    </form>
</body>
</html>
