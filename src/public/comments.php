<?php
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseInteractor\CommentInteractor;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = $_POST['id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

try {
    if (!$user_id) {
        throw new Exception("ユーザーIDが一致しません");
    }
    $useCaseInput = new CommentInput($user_id, $blog_id, $commenter_name, $comments);
    $useCase = new CommentInteractor($useCaseInput);
    $useCaseOutput = $useCase->run();
    redirect("/detail.php?id=$blog_id");
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    redirect('index.php');
}
?>
