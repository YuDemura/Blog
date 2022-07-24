<?php
namespace App\Domain\ValueObject;
use Exception;

/**
 * ハッシュ化したパスワード用のValueObject
 */
final class HashedPassword
{
    /**
     * パスワードが不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = 'パスワードの形式が正しくありません';

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
        if ($value === '') {
            throw new Exception("不正な値です");
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * パスワードの照合
     *
     * @param InputPassword $inputPassword
     * @return bool
     */
    public function verify(InputPassword $inputPassword): bool
    {
        return password_verify($inputPassword->value(), $this->value);
    }
}
