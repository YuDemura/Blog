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

$useCaseInput = new CommentInput($user_id, $blog_id, $commenter_name, $comments);
$useCase = new CommentInteractor($useCaseInput);
$useCaseOutput = $useCase->post();

if ($useCaseOutput->issuccess()) {
    redirect("/detail.php?id=$blog_id");
}

?>
