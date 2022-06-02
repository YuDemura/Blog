<?php
require_once(__DIR__ . '/../../app/Lib/session.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../../app/Lib/login.php');


$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

session_start();
$_SESSION['email'] = $email;

if (empty($email) || empty($password)) {
    appendError("パスワードとメールアドレスを入力してください");
    redirect('signin.php');
}

require_once(__DIR__ . '/../../app/Lib/pdoInit.php');

$member = login($email);

if (!password_verify($password, $member['password'])) {
    appendError("メールアドレスまたはパスワードが違います");
    redirect('signin.php');
}

$_SESSION['user_id'] = $member['id'];
$_SESSION['name'] = $member['name'];
redirect('../index.php');
