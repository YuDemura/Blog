<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseInteractor\SignInInteractor;
use App\Infrastructure\Dao\UserDao;

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
$formInputs = [
    'email' => $email
];
$session->setFormInputs($formInputs);

if (empty($email) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect('./signin.php');
}
$useCaseInput = new SignInInput($email, $password);
$useCase = new SignInInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    redirect('../index.php');
} else {
    $_SESSION['errors'][] = $useCaseOutput->message();
    redirect('./signin.php');
}
