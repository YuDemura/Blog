<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function editMyarticledetail(string $blog_id, string $user_id): ?array
{
	$pdo = pdoInit();

	$sql = "SELECT id, title, contents, created_at from blogs WHERE id=:id and user_id = :user_id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch();
	return $blog;
}
