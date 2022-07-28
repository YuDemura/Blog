<?php
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseInteractor\CreateBlogInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

$session = Session::getInstance();
if ($session){
    if ($_POST) {
        $formInputs = $session->getFormInputs();
        $user_id = $formInputs['user_id'];
        $title = filter_input(INPUT_POST, 'title');
        $contents = filter_input(INPUT_POST, 'contents');
        $userId = new UserId($user_id->value());
        $Title = new Title($title);
        $Contents = new Contents($contents);
        $useCaseInput = new CreateBlogInput($userId, $Title, $Contents);
        $useCase = new CreateBlogInteractor($useCaseInput);
        $useCaseOutput = $useCase->createBlog();
        if ($useCaseOutput->isSuccess()) {
            redirect('/../../mypage.php');
        }
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
