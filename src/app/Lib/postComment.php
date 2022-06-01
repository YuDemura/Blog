<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function postComment(string $user_id, string $blog_id, string $commenter_name, string $comments): void
{
	$pdo = pdoInit();

	$sql = "INSERT INTO comments(user_id, blog_id, commenter_name, comments) VALUES(:user_id, :blog_id, :commenter_name, :comments)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindValue(':blog_id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':commenter_name', $commenter_name, PDO::PARAM_STR);
	$statement->bindValue(':comments', $comments, PDO::PARAM_STR);
	$statement->execute();
}
