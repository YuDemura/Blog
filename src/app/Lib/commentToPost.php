<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function commentToPost(string $blog_id, string $user_id): ?array
{
	$pdo = pdoInit();

	$sql = <<<EOF
		SELECT
			commenter_name, comments, created_at
		FROM
			comments
		WHERE
			blog_id=$blog_id and user_id=$user_id
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$comments_post = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $comments_post;
}
