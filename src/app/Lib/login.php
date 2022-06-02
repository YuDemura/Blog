<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function login(string $email): ?array
{
	$pdo = pdoInit();

	$sql = <<<EOF
		SELECT * FROM
			users
		WHERE
			email = :email
		;
	EOF;
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$member = $statement->fetch(PDO::FETCH_ASSOC);
	return $member;
}
