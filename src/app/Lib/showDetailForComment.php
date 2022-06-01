<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function showDetailForComment(string $blog_id)
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
			id=:id
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
}
