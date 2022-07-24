<?php
namespace App\Domain\ValueObject;
use Exception;
/**
 * メールアドレス用のValueObject
 */
final class Email
{
    /**
     * メールアドレスの書式の正規表現
     */
    const EMAIL_REGULAR_EXPRESSIONS = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";

    /**
     * メールアドレスの書式が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = 'メールアドレスの形式が正しくありません';

    /**
     * @var string
     */
    private $value;

    /**
     * コンストラクタ
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * メールアドレスのバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::EMAIL_REGULAR_EXPRESSIONS, $value);
    }
}
