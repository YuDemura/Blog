<?php
session_start();
include ('header.php');
if ($_SESSION['user_id']) {
    $dbUserName = 'root';
    $dbPassword = 'password';
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);

    $user_id = $_SESSION['user_id'];
    $sql = "select title, created_at, contents, id from blogs where user_id=:user_id and length(contents) <= 15";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <td><?php echo $blog['contents']; ?></td>
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
