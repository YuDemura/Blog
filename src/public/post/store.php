<?php
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseInteractor\CreateBlogInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Adapter\QueryService\UserQueryService;
use App\Infrastructure\Dao\UserDao;
use App\Infrastructure\Dao\BlogDao;
use App\Adapter\Repository\BlogRepository;

$session = Session::getInstance();
if (!$session){
    redirect('./user/signin.php');
}

if (!$_POST) {
    redirect('/../../index.php');
}

if ($_POST) {
    $formInputs = $session->getFormInputs();
    $user_id = $formInputs['user_id'];
    $title = filter_input(INPUT_POST, 'title');
    $contents = filter_input(INPUT_POST, 'contents');
    try {
        if (empty($title) || empty($contents)) {
            throw new Exception('タイトルとブログ内容を入力して下さい');
        }
        $userId = new UserId($user_id->value());
        $Title = new Title($title);
        $Contents = new Contents($contents);
        $useCaseInput = new CreateBlogInput($userId, $Title, $Contents);
        $userDao = new UserDao();
        $blogDao = new BlogDao();
        $userQueryService = new UserQueryService($userDao);
        $blogRepository = new BlogRepository($blogDao);
        $useCase = new CreateBlogInteractor($useCaseInput, $userQueryService, $blogRepository);
        $useCaseOutput = $useCase->handler();
        redirect('/../../mypage.php');
    } catch (Exception $e) {
        $_SESSION['errors'][] = $e->getMessage();
        redirect('./create.php');
    }
}
?>
