<?php
namespace App\Domain\ValueObject;
use Exception;
/**
 * ユーザーの名前用のValueObject
 */
final class UserName
{
    /**
     * ユーザーの名前が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = 'ユーザー名は20文字以下でお願いします！';

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
     * ユーザー名のバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return mb_strlen($value) > 20;
    }
}
