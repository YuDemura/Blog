<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$email = filter_input(INPUT_POST, 'email');
$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');

session_start();
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;

if (empty($password) || empty($password_conf)) {
    $_SESSION['errors'][] = 'パスワードを入力してください';
    header('Location: ./signup.php');
    exit();
}

if ($password !== $password_conf) {
    $_SESSION['errors'][] = 'パスワードが一致しません';
    header('Location: ./signup.php');
    exit();
}

$sql = 'select * from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch();

if ($member) {
    $_SESSION['errors'][] = 'すでに登録済みのメールアドレスです';
    header('Location: ./signup.php');
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql =
    'INSERT INTO `users`(`name`, `email`, `password`) VALUES (:name, :email, :password)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
$statement->execute();

$_SESSION['registed'] = '登録できました。';
header('Location: ./signin.php');
exit();
