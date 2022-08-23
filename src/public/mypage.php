<?php
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Infrastructure\Dao\BlogDao;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$messages = $session->getMessage();

if (!isset($formInputs['user_id'])) {
    redirect('./user/signin.php');
}
require_once(__DIR__ . '/header.php');

$blogDao = new BlogDao();
if ($formInputs['user_id']) {
    $user_id = $formInputs['user_id'];
    $blogs = $blogDao->showMypage($user_id->value());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>マイページ</title>
</head>
<body>
    <?php foreach ($messages as $message): ?>
        <p><?php echo $message; ?></p>
    <?php endforeach; ?>
    <h1>マイページ</h1>
    <p><a href="./post/create.php">新規作成</a></p>
    <?php foreach ((array)$blogs as $blog): ?>
    <table>
        <tr>
            <td><?php echo $blog['title']; ?></td>
        </tr>
        <tr>
            <td><?php echo $blog['created_at']; ?></td>
        </tr>
        <tr>
            <td><?php echo mb_substr($blog['contents'], 0, 15, 'UTF-8') . "・・・"; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./myarticledetail.php?id=<?php echo $blog['id']; ?>">記事詳細へ</a></td>
        </tr>
    </table>
    <?php endforeach; ?>
</body>
</html>
