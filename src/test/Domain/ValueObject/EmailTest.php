<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Email;

final class EmailTest extends TestCase
{
    /**
     * @test
     * メールアドレスの書式はHTML仕様のメールアドレスの正規表現にTLDの制限加えたもの
     */
    public function メールアドレスの書式が正しい場合_例外が発生しないこと(): void
    {
        $actual = new Email('techquest@gmail.com');

        $this->assertSame('techquest@gmail.com', $actual->value());
    }

    /**
     * @test
     */
    public function メールアドレスの書式が不正の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Email('me');
    }
}
