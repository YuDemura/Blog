<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';

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
    redirect('signin.php');
}

$userDao = new UserDao();
$member = $userDao->login($email);

if (!password_verify($password, $member['password'])) {
    $session->appendError("メールアドレスまたはパスワードが違います");
    redirect('signin.php');
}

$formInputs = [
    'user_id' => $member['id'],
    'name' => $member['name']
];
$session->setFormInputs($formInputs);

redirect('../index.php');
