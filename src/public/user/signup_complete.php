<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';

use App\Infrastructure\Dao\UserDao;


$email = filter_input(INPUT_POST, 'email');
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');

$session = Session::getInstance();
$formInputs = [
    'email' => $email,
    'name' => $name
];
$session->setFormInputs($formInputs);

if (empty($password) || empty($password_conf)) {
    $session->appendError("パスワードを入力してください");
    redirect('signup.php');
}
if ($password !== $password_conf) {
    $session->appendError("パスワードが一致しません");
    redirect('signup.php');
}

$userDao = new UserDao();
$member = $userDao->findUserByMail($email);
if ($member) {
    $session->appendError("すでに登録済みのメールアドレスです");
    redirect('signup.php');
}

$userDao->createUser($name, $email, $password);

$successRegistedMessage = '登録できました。';
$session->setMessage($successRegistedMessage);
redirect('signin.php');
