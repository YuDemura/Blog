<?php
session_start();
$dbUserName = 'root';
$dbPassword = 'password';
try {
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$sql = "select title, created_at, contents, id from blogs where id=:id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $blog_id, PDO::PARAM_INT);
$statement->execute();
$blog = $statement->fetch();

$sql = "SELECT commenter_name, comments, created_at FROM comments WHERE blog_id=$blog_id and user_id=$user_id";
$statement = $pdo->prepare($sql);
$statement->execute();
$comments_post = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>記事の詳細ページ</title>
</head>
<body>
    <h1><?php echo $blog['title'] ?></h1>

        <table>
            <tr>
                <td><?php echo $blog['created_at'] ?></td>
            </tr>
            <tr>
                <td><?php echo $blog['contents'] ?></td>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td><a href="./index.php">一覧ページへ</a></td>
            </tr>
        </table>

        <form method="POST" action="/comments.php">
        <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
        <table>
        <p><strong>この投稿にコメントしますか？</strong></p>
        <tr>
            <td>コメント名</td>
        </tr>
        <tr>
            <td><input type="text" name="commenter_name"></td>
        </tr>
        <tr>
            <td>内容</td>
        </tr>
        <tr>
            <td><textarea name="comments" rows="8" cols="40"></textarea></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="submit" name="btn1" value="コメント"></td>
        </tr>
        </table>
        </form>
        <table>
            <tr>
                <td>コメント一覧</td>
            </tr>
        <?php foreach ((array)$comments_post as $comment): ?>
            <tr>
            <td><?php echo $comment['commenter_name']; ?></td>
            </tr>
            <tr>
            <td><?php echo $comment['comments']; ?></td>
            </tr>
            <tr>
            <td><?php echo $comment['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
</body>
