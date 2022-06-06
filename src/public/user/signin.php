<?php
require_once(__DIR__ . '/../../app/Lib/session.php');
$session = Session::getInstance();
// var_dump($session);
$errors = $session->popAllErrors();
// var_dump($errors);
$successRegistedMessage = $session->getMessage();
// var_dump($successRegistedMessage);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200 w-full h-screen flex justify-center items-center">
    <div class="w-96  bg-white pt-10 pb-10 rounded-xl">
        <div class="w-60 m-auto text-center">
            <h2 class="text-2xl mb-5">ログイン</h2>
            <h3 class="mb-5 text-xl"><?php echo $successRegistedMessage; ?></h3>
            <p class="text-red-600"><?php echo $error; ?></p>
            <form class="px-4" action="./signin_complete.php" method="POST">
                <p><input class="border-2 border-gray-300 mb-5 w-full" type=“text” name="email" type="mail" required placeholder="Email" value="<?php if (
                    isset($_SESSION['email'])
                ) {
                    echo $_SESSION['email'];
                } ?>"></p>
                <p><input class="border-2 border-gray-300 mb-5 w-full" type="password" placeholder="Password" name="password"></p>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mb-5 w-full" type="submit">ログイン</button>
            </form>
            <a class="text-blue-500" href="./signup.php">アカウントを作る</a>
        </div>
    </div>
</body>

</html>
