<?php
require_once(__DIR__ . '/../../app/Lib/session.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../../app/Lib/login.php');


$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
// var_dump($session);die;
$formInputs = [
    'email' => $email
];
$session->setFormInputs($formInputs);
// var_dump($session);die;
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
// var_dump($member['id']);die;
// var_dump($member['name']);die;
$formInputs = [
    'user_id' => $member['id'],
    'name' => $member['name']
];
// var_dump($formInputs);die;
$session->setFormInputs($formInputs);

// var_dump($_SESSION['user_id']);die;

redirect('../index.php');
