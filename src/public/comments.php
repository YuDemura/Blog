<?php
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseInteractor\CommentInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommenterName;
use App\Domain\ValueObject\Comments;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = $_POST['id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

$UserId = new UserId($user_id->value());
$BlogId = new BlogId($blog_id);
$CommenterName = new CommenterName($commenter_name);
$Comments = new Comments($comments);
$useCaseInput = new CommentInput($UserId, $BlogId, $CommenterName, $Comments);
$useCase = new CommentInteractor($useCaseInput);
$useCaseOutput = $useCase->run();

if ($useCaseOutput->isSuccess()) {
    redirect("/detail.php?id=$blog_id");
}

?>
