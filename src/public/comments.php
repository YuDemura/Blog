<?php
require_once(__DIR__ . '/../app/Lib/postComment.php');
require_once(__DIR__ . '/../app/Lib/redirect.php');
session_start();

$blog_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

postComment($user_id, $blog_id, $commenter_name, $comments);
redirect("/detail.php?id=$blog_id");
?>
