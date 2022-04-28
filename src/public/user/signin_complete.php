<?php
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

session_start();
$_SESSION['email'] = $email;

if (empty($email) || empty($password)) {
    $_SESSION['errors'] = 'パスワードとメールアドレスを入力してください';
    header('Location: ./signin.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'select * from users where email = :email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $member['password'])) {
    $_SESSION['errors'] = 'メールアドレスまたはパスワードが違います';
    header('Location: ./signin.php');
    exit();
}

$_SESSION['user_id'] = $member['id'];
$_SESSION['name'] = $member['name'];
header('Location: ../index.php');
exit();
