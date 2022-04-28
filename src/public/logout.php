<?php
session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 4200, '/');
}
session_destroy();
header('Location: ./user/signin.php');
exit();
?>
