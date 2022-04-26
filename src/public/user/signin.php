<?php
session_start();
$msg = [];
if ($_POST) {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    if (!$email) {
        $msg[] = 'メールアドレスを入力してください';
    }

    if (!$password) {
        $msg[] = 'パスワードを入力してください';
    }

    if (!$msg) {
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
            if (password_verify(trim($_POST['password']), $member['password'])) {
            session_regenerate_id(true);
            $_SESSION['email'] = $member['email'];
            $_SESSION['password'] = $member['password'];
            $_SESSION['user_id'] = $member['id'];
            $_SESSION['name'] = $member['name'];
            header('Location: /index.php');
            } else {
                $msg[] = 'パスワードが違います。';
            }
        } else {
            $msg[] = 'メールアドレスが違います。';
        }
    }
}
?>

<form action="/user/signin.php" method="post">
    <body>
    <?php if ($msg) : ?>
        <?php foreach ($msg as $m) : ?>
            <p><?php echo $m ?></p>
        <?php endforeach; ?>
        <?php endif; ?>
    <table>
        <tr>
            <td><p>ログイン</p></td>
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
            <td><input type="submit" value="ログイン"></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="./signup.php">アカウントを作る</a></td>
        </tr>
    </table>
    </body>
</form>
