<?php
session_start();

$dbUserName = 'root';
$dbPassword = 'password';
try {
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$blog_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

$sql = "INSERT INTO comments(commenter_name, comments, blog_id, user_id) VALUES(:commenter_name, :comments, :blog_id, :user_id)";
$statement = $pdo->prepare($sql);
$statement->bindValue(':commenter_name', $commenter_name, PDO::PARAM_STR);
$statement->bindValue(':comments', $comments, PDO::PARAM_STR);
$statement->bindValue(':blog_id', $blog_id, PDO::PARAM_INT);
$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$statement->execute();

header("Location: /detail.php?id=$blog_id");
exit();
?>
