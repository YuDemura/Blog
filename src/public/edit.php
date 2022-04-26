<?php
session_start();

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);

$user_id = $_SESSION['user_id'];
$blog_id = filter_input(INPUT_GET, 'id');

$sql = "select title, contents, id from blogs where user_id=:user_id and id=:id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$statement->bindParam(':id', $blog_id, PDO::PARAM_INT);
$statement->execute();
$blog = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>記事の編集ページ</title>
</head>
<body>
    <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
    <table>
        <tr>
            <td>タイトル</td>
        </tr>
        <tr>
            <td><input type="text" name="title" value="<?php echo $blog['title'] ?>"></td>
        </tr>
        <tr>
            <td>内容</td>
        </tr>
        <tr>
            <td><textarea cols="100" rows="10" name="contents"> <?php echo $blog['contents'] ?></textarea>"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><p><input type="submit" value="編集"></p></td>
        </tr>
    </table>
    </form>
</body>
