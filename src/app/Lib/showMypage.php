<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function showMypage(string $user_id): ?array
{
	$pdo = pdoInit();

	$sql = <<<EOF
		SELECT
			id
			, title
			, contents
			, created_at
		FROM
			blogs
		WHERE
			user_id=:user_id
			and
			length(contents) <= 15
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $blogs;
}
