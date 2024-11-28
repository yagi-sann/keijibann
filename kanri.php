<?php
session_start();

define('ADMIN_PASSWORD', '123456789');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])) {
    if ($_POST["password"] === ADMIN_PASSWORD) {
        $_SESSION["authenticated"] = true;
    } else {
        echo "<p>パスワードが間違っています。</p>";
        exit;
    }
}

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: kanri.html");
    exit;
}

$file = 'keijiban.txt';
$posts = file_exists($file) ? explode("<hr>\n", file_get_contents($file)) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && is_array($_POST["delete"])) {
    $toDelete = $_POST["delete"];
    foreach ($toDelete as $index) {
        unset($posts[$index]);
    }
    $posts = array_filter($posts, 'trim');
    file_put_contents($file, implode("<hr>\n", $posts));
}

$posts = file_exists($file) ? explode("<hr>\n", file_get_contents($file)) : [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理ページ - 投稿削除</title>
</head>
<body>
    <h1>管理ページ</h1>
    <h2>投稿の削除</h2>
    <form action="kanri.php" method="post">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $index => $post): ?>
                <?php if (trim($post) !== ""): ?>
                    <div>
                        <input type="checkbox" name="delete[]" value="<?php echo $index; ?>">
                        <?php echo htmlspecialchars($post, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="submit" value="選択した投稿を削除">
        <?php else: ?>
            <p>投稿がありません。</p>
        <?php endif; ?>
    </form>
</body>
</html>
