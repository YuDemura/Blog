<?php
$msg = [];
if ($_POST) {
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $password_conf = filter_input(INPUT_POST, 'password_conf');

    if (!$email) {
        $msg[] = 'メールアドレスを入力してください';
    }

    if (!$password) {
        $msg[] = 'パスワードを入力してください';
    }

    if ($password !== $password_conf) {
        $msg[] = 'パスワードが一致しません';
    }

    if (!$msg) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $dbUserName = 'root';
        $dbPassword = 'password';
        try {
            $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword);
        } catch (PDOException $e) {
            $msg[] = $e->getMessage();
        }

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetch();
        if ($member && $member['email'] === $email) {
            $msg[] = '同じメールアドレスが存在します。';
        } else {
            $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            header('Location: /user/signin.php');
        }
    }
}
?>

<form action="/user/signup.php" method="post">
    <body>
    <?php if ($msg) : ?>
        <?php foreach ($msg as $m) : ?>
            <p><?php echo $m ?></p>
        <?php endforeach; ?>
        <?php endif; ?>
    <table>
        <tr>
            <td><p>会員登録</p></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="text" name="name" placeholder="User name"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="email" name="email" placeholder="Email"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="password" name="password" placeholder="Password"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="password" name="password_conf" placeholder="Password確認"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><input type="submit" value="アカウント作成"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./signin.php">ログイン画面へ</a></td>
        </tr>
    </table>
    </body>
</form>
