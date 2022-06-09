<?php
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../../app/Lib/login.php');
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;

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

require_once(__DIR__ . '/../../app/Lib/pdoInit.php');

$member = login($email);

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
