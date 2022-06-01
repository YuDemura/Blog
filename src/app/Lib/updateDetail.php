<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function updateDetail(string $blog_id, string $user_id, string $title, string $contents): void
{
	$pdo = pdoInit();

	$sql = <<<EOF
		UPDATE
			blogs
		SET
			title=:title
			, contents=:contents
		WHERE
			id = :id
			and
			user_id=:user_id
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':title', $title, PDO::PARAM_STR);
	$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
	$statement->bindParam(':id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
}
