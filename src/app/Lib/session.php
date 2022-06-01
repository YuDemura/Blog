<?php

function errorsInit(): array
{
	$errors = $_SESSION['errors'] ?? [];
	unset($_SESSION['errors']);
	return $errors;
}

function registedInit(): string
{
	$registed = $_SESSION['registed'] ?? "";
	$_SESSION['registed'] = "";
	return $registed;
}

function appendError(string $errorMessage): void
{
	$_SESSION['errors'][] = $errorMessage;
}
