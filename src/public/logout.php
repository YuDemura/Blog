<?php
session_start();
$_SESSION = [];
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ログアウト</title>
    </head>
    <body>
        <h1>ログアウトしました</h1>
        <a href="../user/signin.php">ログインする</a>
    </body>
</html>
