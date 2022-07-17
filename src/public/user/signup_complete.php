<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';

use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseInteractor\SignUpInteractor;

$email = filter_input(INPUT_POST, 'email');
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');

try {
    $session = Session::getInstance();
    if (empty($password) || empty($password_conf)) {
        throw new Exception('パスワードを入力してください');
    }
    if ($password !== $password_conf) {
        throw new Exception('パスワードが一致しません');
    }

    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);
    $useCaseInput = new SignUpInput($userName, $userEmail, $userPassword);
    $useCase = new SignUpInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    $_SESSION['errors'][] = $useCaseOutput->message();
    redirect('signin.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    $formInputs = [
        'email' => $email,
        'name' => $name
    ];
    $session->setFormInputs($formInputs);
    redirect('signup.php');
}
