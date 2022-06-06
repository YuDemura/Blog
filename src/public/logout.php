<?php
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once(__DIR__ . '/../app/Lib/session.php');

$session = Session::getInstance();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 4200, '/');
}
session_destroy();
redirect('./user/signin.php');
?>
