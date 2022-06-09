<?php
require_once(__DIR__ . '/../app/Lib/postComment.php');
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = $_POST['id'];
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

postComment($user_id, $blog_id, $commenter_name, $comments);
redirect("/detail.php?id=$blog_id");
?>
