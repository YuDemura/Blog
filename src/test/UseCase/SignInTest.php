<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseInteractor\SignInInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\NewUser;
use App\Domain\Entity\User;
use App\Domain\InterfaceMapper\UserQueryServiceInterface;

final class SignInTest extends TestCase
{
    /**
     * @test
     */
    public function DBに同じメールのユーザー情報が存在しない場合_falseが返ってくること()
    {
        $input = new SignInInput(
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserByMail(Email $email): ?User
            {
                return null;
            }
        };

        $interactor = new SignInInteractor($input, $userQueryServiceInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function パスワードがハッシュ値と一致しない場合_falseが返ってくること()
    {
        $input = new SignInInput(
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserByMail(Email $email): ?User
            {
                return new User(
                    new UserId(1),
                    new UserName('techquest'),
                    new Email('techquest@gmail.com'),
                    new HashedPassword('techquest2')
                );
            }
        };

        $interactor = new SignInInteractor($input, $userQueryServiceInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function DBに同じメールのユーザー情報が存在するかつパスワードがハッシュ値と一致する場合_trueが返って来ること()
    {
        $input = new SignInInput(
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserByMail(Email $email): ?User
            {
                return new User(
                    new UserId(1),
                    new UserName('techquest'),
                    new Email('techquest@gmail.com'),
                    new HashedPassword(password_hash("techquest1", PASSWORD_DEFAULT))
                );
            }
        };

        $interactor = new SignInInteractor($input, $userQueryServiceInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }
}
