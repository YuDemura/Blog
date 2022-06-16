<?php
namespace App\Lib;

/**
 * Sessionで扱うことができるキーの一覧
 */
final class SessionKey
{
	public const ERROR_KEY = 'errors';
	public const FORM_INPUTS_KEY = 'formInputs';
	public const MESSAGE_KEY = 'message';

	public const KEYS = [
		self::ERROR_KEY,
		self::FORM_INPUTS_KEY,
		self::MESSAGE_KEY
	];

	private $value;

	public function __construct(string $value)
	{
		if (!in_array($value, self::KEYS)) {
			throw new Exception('使用不可能なキーです');
		}
		$this->value = $value;
	}

	public function value(): string
	{
		return $this->value;
	}
}
