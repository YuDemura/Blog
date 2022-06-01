<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function showDetailForComment(string $blog_id)
{
	$pdo = pdoInit();

	$sql = "select id, title, contents, created_at from blogs where id=:id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
}
