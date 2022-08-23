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
    $userId = new UserId($user_id->value());
    $Title = new Title($title);
    $Contents = new Contents($contents);
    $useCaseInput = new CreateBlogInput($userId, $Title, $Contents);
    $useCase = new CreateBlogInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();
    if ($useCaseOutput->isSuccess()) {
        $session->setMessage($useCaseOutput->message());
        redirect('/../../mypage.php');
    } else {
        $session->appendError($useCaseOutput->message());
        redirect('./create.php');
    }
}

?>
