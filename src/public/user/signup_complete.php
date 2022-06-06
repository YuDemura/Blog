<?php
require_once(__DIR__ . '/../../app/Lib/session.php');
require_once(__DIR__ . '/../../app/Lib/findUserByMail.php');
require_once(__DIR__ . '/../../app/Lib/createUser.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');

$email = filter_input(INPUT_POST, 'email');
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');

$session = Session::getInstance();
// var_dump($session);die;
$formInputs = [
    'email' => $email,
    'name' => $name
];
$session->setFormInputs($formInputs);
// var_dump($session);die;
if (empty($password) || empty($password_conf)) {
    $session->appendError("パスワードを入力してください");
    redirect('signup.php');
}
if ($password !== $password_conf) {
    $session->appendError("パスワードが一致しません");
    redirect('signup.php');
}

$member = findUserByMail($email);
if ($member) {
    $session->appendError("すでに登録済みのメールアドレスです");
    redirect('signup.php');
}

createUser($name, $email, $password);

$successRegistedMessage = '登録できました。';
$session->setMessage($successRegistedMessage);
redirect('signin.php');
