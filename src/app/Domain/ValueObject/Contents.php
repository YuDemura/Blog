<?php
namespace App\Domain\ValueObject;
use Exception;
/**
 * ブログ（新規投稿）の内容のValueObject
 */
final class Contents
{
    /**
     * ブログ内容が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = '内容は1000文字以下でお願いします！';

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
     * ブログ内容のバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return mb_strlen($value) > 1000;
    }
}
