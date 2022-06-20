<?php
require_once(__DIR__ . '/../app/Lib/updateDetail.php');
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];
$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

updateDetail($blog_id, $user_id, $title, $contents);
redirect("myarticledetail.php?id=$blog_id");
?>
