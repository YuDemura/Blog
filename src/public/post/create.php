<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
$session = Session::getInstance();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>新規記事</title>
</head>
<body>
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form action="./store.php" method="POST">
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
