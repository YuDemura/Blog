<?php
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseInteractor\EditInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\ValueObject\BlogId;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');
$BlogId = new BlogId($blog_id);
$UserId = new UserId($user_id->value());
$Title = new Title($title);
$Contents = new Contents($contents);
$useCaseInput = new EditInput($BlogId, $UserId, $Title, $Contents);
$useCase = new EditInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();
if ($useCaseOutput->isSuccess()) {
    redirect("myarticledetail.php?id=$blog_id");
}

?>
