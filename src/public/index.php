<?php
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once(__DIR__ . '/../app/Infrastructure/Dao/BlogDao.php');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Lib\Session;
use App\Infrastructure\Dao\BlogDao;

$session = Session::getInstance();

$formInputs = $session->getFormInputs();

if (!isset($formInputs['user_id'])) {
  redirect('./user/signin.php');
}

require_once(__DIR__ . '/header.php');

if (isset($_GET['order'])) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}

if (isset($_GET['search'])) {
    $title = '%' . $_GET['search'] . '%';
    $contents = '%' . $_GET['search'] . '%';
} else {
    $title = '%%';
    $contents = '%%';
}
$user_id = $formInputs['user_id'];
$blogDao = new BlogDao();
$blogs = $blogDao->showList($user_id->value(), $title, $contents, $direction);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>blog一覧</title>
</head>

<body>
  <div>
    <div>
      <form action="" method="get">
          <h1>blog一覧</h1>
        <div>
          <input name="search" type="text" value="<?php echo $_GET['search'] ??
              ''; ?>" placeholder="キーワードを入力" />
         <button type="submit">検索</button>
        </div>
        <div>
            <button type="submit" name="order" value="desc" class="">新しい順</button>
            <button type="submit" name="order" value="asc" class="">古い順</button>
        </div>
      </form>
    </div>
    <div>
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
            <td><a href="./detail.php?id=<?php echo $blog['id']; ?>">記事詳細へ</a></td>
         </tr>
      </table>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
