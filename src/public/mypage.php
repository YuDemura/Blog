<?php
session_start();
require_once(__DIR__ . '/../app/Lib/header.php');
require_once(__DIR__ . '/../app/Lib/showMypage.php');
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $blogs = showMypage($user_id);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>マイページ</title>
</head>
<body>
    <h1>マイページ</h1>
    <p><a href="./post/create.php">新規作成</a></p>
    <?php foreach ((array)$blogs as $blog): ?>
    <table>
        <tr>
            <td><?php echo $blog['title']; ?></td>
        </tr>
        <tr>
            <td><?php echo $blog['created_at']; ?></td>
        </tr>
        <tr>
            <td><?php echo mb_substr($blog['contents'], 0, 15, 'UTF-8') . "・・・"; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./myarticledetail.php?id=<?php echo $blog['id']; ?>">記事詳細へ</a></td>
        </tr>
    </table>
    <?php endforeach; ?>
</body>
</html>
