<?php
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once(__DIR__ . '/../app/Infrastructure/Dao/CommentDao.php');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Infrastructure\Dao\BlogDao;
use App\Infrastructure\Dao\CommentDao;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$user_id = $formInputs['user_id'];
$blog_id = $_GET['id'];

$blogDao = new BlogDao();
$blog = $blogDao->showDetailForComment($blog_id);

$commentDao = new CommentDao();
$comments_post = $commentDao->commentToPost($blog_id, $user_id->value());
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>記事の詳細ページ</title>
</head>
<body>
    <?php foreach ($errors as $error): ?>
        <p class="text-red-600"><?php echo $error; ?></p>
    <?php endforeach; ?>
    <h1><?php echo $blog['title'] ?></h1>

        <table>
            <tr>
                <td><?php echo $blog['created_at'] ?></td>
            </tr>
            <tr>
                <td><?php echo $blog['contents'] ?></td>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td><a href="./index.php">一覧ページへ</a></td>
            </tr>
        </table>

        <form method="POST" action="/comments.php">
        <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
        <table>
        <p><strong>この投稿にコメントしますか？</strong></p>
        <tr>
            <td>コメント名</td>
        </tr>
        <tr>
            <td><input type="text" name="commenter_name"></td>
        </tr>
        <tr>
            <td>内容</td>
        </tr>
        <tr>
            <td><textarea name="comments" rows="8" cols="40"></textarea></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="submit" name="btn1" value="コメント"></td>
        </tr>
        </table>
        </form>
        <table>
            <tr>
                <td>コメント一覧</td>
            </tr>
        <?php foreach ((array)$comments_post as $comment): ?>
            <tr>
            <td><?php echo $comment['commenter_name']; ?></td>
            </tr>
            <tr>
            <td><?php echo $comment['comments']; ?></td>
            </tr>
            <tr>
            <td><?php echo $comment['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
</body>
