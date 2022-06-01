<?php
require_once(__DIR__ . '/../app/Lib/updateDetail.php');
require_once(__DIR__ . '/../app/Lib/redirect.php');
session_start();

$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');
$user_id = $_SESSION['user_id'];

updateDetail($blog_id, $user_id, $title, $contents);
redirect("myarticledetail.php?id=$blog_id");
?>
