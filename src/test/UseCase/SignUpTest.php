<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseInteractor\SignUpInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\NewUser;
use App\Domain\Entity\User;
use App\Domain\InterfaceMapper\UserQueryServiceInterface;
use App\Domain\InterfaceMapper\UserRepositoryInterface;

final class SignUpTest extends TestCase
{
    /**
     * @test
     */
    public function DBに同じメールのユーザー情報が存在しない場合_trueが返ってくること()
    {
        $input = new SignUpInput(
            new UserName('techquest'),
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserByMail(Email $email): ?User
            {
                return null;
            }
        };

        $userRepositoryInterface = new class implements UserRepositoryInterface {
            public function insert(NewUser $user): void
            {
            }
        };
        $interactor = new SignUpInteractor($input, $userQueryServiceInterface, $userRepositoryInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function DBに同じメールのユーザー情報が存在する場合_falseが返ってくること(): void
    {
        $input = new SignUpInput(
            new UserName('techquest'),
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
                    new HashedPassword('techquest1')
                );
            }
        };

        $userRepositoryInterface = new class implements UserRepositoryInterface {
            public function insert(NewUser $user): void
            {
            }
        };

        $interactor = new SignUpInteractor($input, $userQueryServiceInterface, $userRepositoryInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }
}
