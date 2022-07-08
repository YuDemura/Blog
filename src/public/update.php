<?php
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseInteractor\EditInteractor;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

$useCaseInput = new EditInput($blog_id, $user_id, $title, $contents);
$useCase = new EditInteractor($useCaseInput);
$useCaseOutput = $useCase->updateBlog();
if ($useCaseOutput->isSuccess()) {
    redirect("myarticledetail.php?id=$blog_id");
}

?>
