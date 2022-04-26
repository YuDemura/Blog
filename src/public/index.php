<?php
session_start();
include ('header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location:/user/signin.php");
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
try {
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

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

$user_id = $_SESSION['user_id'];
$sql = "SELECT title, created_at, contents, id FROM blogs WHERE user_id=:user_id and title LIKE :title OR contents LIKE :contents and length(contents) <= 15 ORDER BY id $direction";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':contents', $contents, PDO::PARAM_STR);
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
          <label>
            <input type="submit" name="order" value="desc" class="">
            <span>新しい順</span>
          </label>
          <label>
            <input type="submit" name="order" value="asc" class="">
            <span>古い順</span>
          </label>
        </div>
      </form>
    </div>
    <div>
    <?php foreach ($blogs as $blog): ?>
      <table>
          <tr>
            <td><?php echo $blog['title']; ?></td>
          </tr>
          <tr>
            <td><?php echo $blog['created_at']; ?></td>
          </tr>
          <tr>
            <td><?php echo $blog['contents']; ?></td>
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
