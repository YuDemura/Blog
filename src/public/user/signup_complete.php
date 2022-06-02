<?php
require_once(__DIR__ . '/../../app/Lib/session.php');
require_once(__DIR__ . '/../../app/Lib/findUserByMail.php');
require_once(__DIR__ . '/../../app/Lib/createUser.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');

$email = filter_input(INPUT_POST, 'email');
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');

session_start();
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;

if (empty($password) || empty($password_conf)) {
    appendError("パスワードを入力してください");
    redirect('signup.php');
}
if ($password !== $password_conf) {
    appendError("パスワードが一致しません");
    redirect('signup.php');
}

$member = findUserByMail($email);
if ($member) {
    appendError("すでに登録済みのメールアドレスです");
    redirect('signup.php');
}

createUser($name, $email, $password);

$_SESSION['registed'] = '登録できました。';
redirect('signin.php');
