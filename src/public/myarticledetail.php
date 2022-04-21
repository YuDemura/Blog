<?php
session_start();

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);

$user_id = $_SESSION['user_id'];
$blog_id = filter_input(INPUT_GET, 'id');

$sql = "SELECT title, created_at, contents, id from blogs WHERE user_id = :user_id and id=:id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
$statement->execute();
$blog = $statement->fetch();

if (isset($_POST['delete'])) {
    $sql = "DELETE FROM blogs where user_id = :user_id and id =:id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':id', $blog_id, PDO::PARAM_INT);
    $statement->execute();
    header('Location: /mypage.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>記事の詳細ページ</title>
</head>
<body>
    <form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
    <h1><?php echo $blog['title']; ?></h1>
    <table>
        <tr>
            <td><?php echo $blog['created_at']; ?></td>
        </tr>
        <tr>
            <td><?php echo $blog['contents']; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./edit.php?id=<?php echo $blog['id']; ?>">編集</a></td>
            <td><input type="submit" name="delete" value="削除">
            </td>
            <td><a href="./mypage.php?id=<?php echo $blog['id']; ?>">マイページへ</a></td>
        </tr>
    </table>
    </form>
</body>
