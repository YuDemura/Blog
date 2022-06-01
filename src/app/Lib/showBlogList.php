<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function showBlogList(string $user_id, string $title, string $contents): ?array
{
	$pdo = pdoInit();

	$sql = "SELECT title, created_at, contents, id FROM blogs WHERE user_id=:user_id and title LIKE :title OR contents LIKE :contents and length(contents) <= 15 ORDER BY id $direction";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindValue(':title', $title, PDO::PARAM_STR);
	$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
	$statement->execute();
	$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $blogs;
}
