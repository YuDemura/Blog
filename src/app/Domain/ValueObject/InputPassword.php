<?php
namespace App\Domain\ValueObject;
use Exception;

require_once __DIR__ . '/HashedPassword.php';

/**
 * ユーザーが入力したパスワード用のValueObject
 */
final class InputPassword
{
    /**
     * パスワードの書式の正規表現
     * 半角英数字両方を含む、8文字以上の正規表現
     */
    const PASSWORD_REGULAR_EXPRESSIONS = '/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i';

    /**
     * パスワードの書式が不正な場合のエラーメッセージ
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
     * ユーザーが入力したパスワードをハッシュ化したパスワードに変換する
     *
     * @return HashedPassword
     */
    public function hash(): HashedPassword
    {
        return new HashedPassword(
            password_hash($this->value, PASSWORD_DEFAULT)
        );
    }

    /**
     * パスワードが正しいかどうかを判定する
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::PASSWORD_REGULAR_EXPRESSIONS, $value);
    }
}
