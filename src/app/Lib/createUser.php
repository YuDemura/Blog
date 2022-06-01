<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function createUser(string $name, string $email, string $password): void
{
	$pdo = pdoInit();

	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':name', $name, PDO::PARAM_STR);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);
	$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
	$statement->execute();
}
