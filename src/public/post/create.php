<?php
$msg = [];
session_start();
if ($_SESSION){
    if ($_POST) {
        $dbUserName = 'root';
        $dbPassword = 'password';
        try {
            $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
        } catch (PDOException $e) {
            $msg[] = $e->getMessage();
        }
        //セッションuser_idも入れる！！
        $user_id = $_SESSION['user_id'];
        $title = filter_input(INPUT_POST, 'title');
        $contents = filter_input(INPUT_POST, 'contents');
        $sql = 'INSERT INTO blogs(user_id, title, contents) VALUES(:user_id, :title, :contents)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':title', $title, PDO::PARAM_STR);
        $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        header('Location:/mypage.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>新規記事</title>
</head>
<body>
    <form action="" method="POST">
        <table>
            <tr>
                <td><p>新規記事</p></td>
            </tr>
            <tr>
                <td>タイトル</td>
            </tr>
            <tr>
                <td><input type="text" name="title"></td>
            </tr>
            <tr>
                <td>内容</td>
            </tr>
            <tr>
                <td><textarea cols="100" rows="10" name="contents"></textarea></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td><button type="submit" name="button">新規作成</button></td>
            </tr>
        </table>
    </form>
</body>
</html>
