<?php
/**
  * セッションの操作を行うクラス
  */
final class Session
{
	private const ERROR_KEY = 'errors';
	private const FORM_INPUTS_KEY = 'formInputs';
	private const MESSAGE_KEY = 'message';
	private static $instance;

	private function __construct()
	{
	}

	/**
      * 1回目であれば自身のインスタンスを生成し、返す。
      * セッション処理の開始をする。
      *
      * @return self
      */
	public static function getInstance(): self
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		self::start();
		return self::$instance;
	}

	/**
      * セッション処理が開始されていなければ開始する。
      *
      * @return void
      */
	private static function start(): void
	{
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	/**
      * セッションにエラー文を保存する。
      *
      * @param string $errorMessage エラー文
      * @return void
      */
	public function appendError(string $errorMessage): void
	{
		$_SESSION[self::ERROR_KEY][] = $errorMessage;
	}

	/**
      * セッションに保存されているエラー文を返す。
      * セッションに保存されているエラー文を削除する。
      * @return array
      */
	public function popAllErrors(): array
	{
		$errors = $_SESSION[self::ERROR_KEY] ?? [];
		$this->clear(self::ERROR_KEY);
		return $errors;
	}

	/**
      * 引数で受け取ったキーのセッションに保存されているデータを削除する。
      *
      * @param string $sessionKey 削除するセッションキー
      * @return void
      */
	public function clear(string $sessionKey): void
	{
		unset($_SESSION[$sessionKey]);
	}

	/**
      * 入力されたフォームのデータをセッションに保存する。
      * ex.
      * フォーム送信時にエラーになった場合、入力されていた情報をフォームにセットし直す場合などに使用。
      *
      * @param string $formInputs 入力されたフォームのデータ
      * @return void
      */
	public function setFormInputs(array $formInputs): void
	{
		// var_dump($forminputs);die;
		foreach ($formInputs as $key => $formInput) {
			$_SESSION[self::FORM_INPUTS_KEY][$key] = $formInput;
		}
	}

	/**
      * セッションに保存されているフォームのデータを返す。
      *
      * @return array
      */
	public function getFormInputs(): array
	{
		return $_SESSION[self::FORM_INPUTS_KEY] ?? [];
	}

	/**
		* セッションにメッセージデータを保存する。
		*
		* @param string $message メッセージデータ
		* @return void
		*/
	public function setMessage($message): void
	{
		$_SESSION[self::MESSAGE_KEY] = $message;
	}

	/**
      * セッションに保存されているメッセージデータを返す。
      *
      * @return string
      */
	public function getMessage(): string
	{
		$message = $_SESSION[self::MESSAGE_KEY] ?? '';
		$this->clear(self::MESSAGE_KEY);
		return $message;
	}
}
