<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function findUserByMail(string $mail)
{
	$pdo = pdoInit();

	$sql = "SELECT * FROM users WHERE email = :email";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$member = $statement->fetch(PDO::FETCH_ASSOC);
    // var_dump($member);die;
	return $member;
}
