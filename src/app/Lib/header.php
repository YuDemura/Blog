<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Lib\Session;
$session = Session::getInstance();
$formInputs = $session->getFormInputs();
$name = $formInputs['name'];
?>
<header>
<div class="w-full">
	<nav class="bg-white shadow-lg">
		<div class="md:flex items-center justify-between py-2 px-8 md:px-12">
			<div class="flex justify-between items-center">
				<div class="text-2xl font-bold text-gray-800 md:text-3xl">
						Blogアプリ
				</div>
			</div>
		<div class="flex flex-col md:flex-row hidden md:block -mx-2">
    <h1>こんにちは！<?php echo $name; ?>さん</h1>
        <a href="index.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ホーム</a>
        <a href="mypage.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">マイページ</a>
        <a href="logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
      	</div>
		</div>
	</nav>
</div>
</header>
