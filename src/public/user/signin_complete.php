<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseInteractor\SignInInteractor;

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
$formInputs = [
    'email' => $email
];
$session->setFormInputs($formInputs);

try {
    if (empty($email) || empty($password)) {
        throw new Exception('パスワードとメールアドレスを入力してください');
    }

    $userEmail = new Email($email);
    $inputPassword = new InputPassword($password);
    $useCaseInput = new SignInInput($userEmail, $inputPassword);
    $useCase = new SignInInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    $_SESSION['errors'][] = $useCaseOutput->message();
    redirect('../index.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    redirect('./signin.php');
}
