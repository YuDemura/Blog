<?php
namespace App\Domain\ValueObject;

/**
 * ユーザーID用のValueObject
 */
final class UserId
{
    const MIN_VALUE = 1;
    const INVALID_MESSAGE = '不正な値です';
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
     * 1以上かどうかを判定する
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return (int)$value < self::MIN_VALUE;
    }
}
