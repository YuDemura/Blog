<?php
require_once(__DIR__ . '/../app/Lib/showDetail.php');
require_once(__DIR__ . '/../app/Lib/session.php');

$session = Session::getInstance();
$formInputs = [
    'user_id' => $user_id
];
$session->setFormInputs($formInputs);

$blog_id = filter_input(INPUT_GET, 'id');

$blog = showDetail($user_id, $blog_id);
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
