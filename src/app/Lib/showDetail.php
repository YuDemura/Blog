<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function showDetail(string $user_id, string $blog_id)
{
	$pdo = pdoInit();

	$sql = <<<EOF
		SELECT
			id
			, title
			, contents
		FROM
			blogs
		WHERE
			id=:id
			and
			user_id=:user_id
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
}
