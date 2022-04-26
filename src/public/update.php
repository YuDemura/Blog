<?php
session_start();

$dbUserName = 'root';
$dbPassword = 'password';
try {
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');
$user_id = $_SESSION['user_id'];

$sql = 'UPDATE blogs SET title=:title, contents=:contents WHERE id = :id and user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
$statement->execute();

header("Location: /myarticledetail.php?id=$blog_id");
exit();
?>
