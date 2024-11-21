<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
    $allergy = htmlspecialchars($_POST["allergy"], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES, 'UTF-8');

    $file = 'keijiban.txt';
    $current = file_get_contents($file);
    $current .= "<strong>ニックネーム:</strong> $name<br><strong>アレルギー:</strong> $allergy<br><strong>メッセージ:</strong> $message<br><hr>\n";
    file_put_contents($file, $current);
}

if (isset($_GET['action']) && $_GET['action'] === 'load') {
    echo file_exists('keijiban.txt') ? file_get_contents('keijiban.txt') : '';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['allergy']) && !empty($_GET['allergy'])) {
    $allergy = htmlspecialchars($_GET['allergy'], ENT_QUOTES, 'UTF-8');
    $file = 'keijiban.txt';
    if (file_exists($file)) {
        $posts = file($file);
        $filtered_posts = array_filter($posts, function($post) use ($allergy) {
            return strpos($post, "<strong>アレルギー:</strong> $allergy<br>") !== false;
        });
        echo implode("", $filtered_posts);
    } else {
        echo '';
    }
    echo '<button onclick="window.location.href=\'keijiban.html\'">検索前の画面に戻る</button>';
    exit;
}

header("Location: keijiban.html");
exit;
?>
