<?php
require_once(__DIR__ . '/../../app/Lib/createBlog.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../Lib/session.php');
$session = Session::getInstance();
if ($_SESSION){
    if ($_POST) {
        $formInputs = [
            'user_id' => $user_id
        ];
        $session->setFormInputs($formInputs);
        $title = filter_input(INPUT_POST, 'title');
        $contents = filter_input(INPUT_POST, 'contents');
        createBlog($user_id, $title, $contents);
        redirect('/mypage.php');
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
