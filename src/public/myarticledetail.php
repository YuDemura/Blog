<?php
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Infrastructure\Dao\BlogDao;
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseInteractor\DeleteInteractor;
use App\Domain\ValueObject\BlogId;
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\BlogRepository;

$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$user_id = $formInputs['user_id'];

$blog_id = filter_input(INPUT_GET, 'id');
$blogDao = new BlogDao();
$blog = $blogDao->edit($blog_id, $user_id->value());
if (isset($_POST['delete'])) {
    $BlogId = new BlogId($blog_id);
    $useCaseInput = new DeleteInput($BlogId);
    $blogQueryService = new BlogQueryService($blogDao);
    $blogRepository = new BlogRepository($blogDao);
    $useCase = new DeleteInteractor($useCaseInput, $blogQueryService, $blogRepository);
    $useCaseOutput = $useCase->handler();
    if ($useCaseOutput->isSuccess()) {
        redirect('/mypage.php');
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>記事の詳細ページ</title>
</head>
<body>
    <form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $blog['id'] ?>">
    <h1><?php echo $blog['title']; ?></h1>
    <table>
        <tr>
            <td><?php echo $blog['created_at']; ?></td>
        </tr>
        <tr>
            <td><?php echo $blog['contents']; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./edit.php?id=<?php echo $blog['id']; ?>">編集</a></td>
            <td><input type="submit" name="delete" value="削除">
            </td>
            <td><a href="./mypage.php?id=<?php echo $blog['id']; ?>">マイページへ</a></td>
        </tr>
    </table>
    </form>
</body>
