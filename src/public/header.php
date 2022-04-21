<?php
session_start();
$name =$_SESSION['name'];
?>
<header>
<div class="container">
    <h1>こんにちは！<?php echo $name; ?>さん</h1>
      <ul>
        <a href="index.php">ホーム</a> <a href="mypage.php">マイページ</a> <a href="logout.php">ログアウト</a>
      </ul>
    </div>
</header>
