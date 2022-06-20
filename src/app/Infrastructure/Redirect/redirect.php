<?php

function redirect(string $redirectPath): void
{
	header("Location: " . $redirectPath);
	exit;
}
