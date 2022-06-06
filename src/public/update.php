<?php
require_once(__DIR__ . '/../app/Lib/updateDetail.php');
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once(__DIR__ . '/../app/Lib/session.php');
$session = Session::getInstance();
$formInputs = [
    'user_id' => $user_id
];
$session->setFormInputs($formInputs);
$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

updateDetail($blog_id, $user_id, $title, $contents);
redirect("myarticledetail.php?id=$blog_id");
?>
