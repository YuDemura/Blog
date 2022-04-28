<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
// unset($_SESSION['errors']);
?>
​
<!DOCTYPE html>
<html lang="ja">
​
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
</head>
​
<body>
  <div>
    <div>
      <h2>会員登録</h2>
      <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
      <?php endforeach; ?>
      <form action="./signup_complete.php" method="POST">
        <p>
          <input placeholder="User name" type=“text” name="name" required value="<?php if (
              isset($_SESSION['name'])
          ) {
              echo $_SESSION['name'];
          } ?>">
        </p>
        <p><input placeholder="Email" type=“email” name="email" required value="<?php if (
            isset($_SESSION['email'])
        ) {
            echo $_SESSION['email'];
        } ?>"></p>
        <p><input placeholder="Password" type="password" name="password"></p>
        <p><input placeholder="Password確認" type="password" name="password_conf"></p>
        <button type="submit">アカウント作成</button>
      </form>
      <a href="./signin.php">ログイン画面へ</a>
    </div>
  </div>
</body>
​
</html>
