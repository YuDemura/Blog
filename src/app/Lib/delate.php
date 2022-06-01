<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function delate(string $user_id, string $blog_id): void
{
	$pdo = pdoInit();

	$sql = "DELETE FROM blogs where user_id = :user_id and id =:id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindParam(':id', $blog_id, PDO::PARAM_INT);
	$statement->execute();
}
