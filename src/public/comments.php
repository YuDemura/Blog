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
use App\Infrastructure\Dao\CommentDao;
use App\Infrastructure\Dao\BlogDao;
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\CommentRepository;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = $_POST['id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

try {
    if (empty($commenter_name) || empty($comments)) {
        throw new Exception('コメント名とコメント内容を入力して下さい');
    }
    $UserId = new UserId($user_id->value());
    $BlogId = new BlogId($blog_id);
    $CommenterName = new CommenterName($commenter_name);
    $Comments = new Comments($comments);
    $useCaseInput = new CommentInput($UserId, $BlogId, $CommenterName, $Comments);
    $commentDao = new CommentDao();
    $blogDao = new BlogDao();
    $blogQueryService = new BlogQueryService($blogDao);
    $commentRepository = new CommentRepository($commentDao);
    $useCase = new CommentInteractor($useCaseInput, $blogQueryService, $commentRepository);
    $useCaseOutput = $useCase->handler();
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
}
redirect("/detail.php?id=$blog_id");
?>
