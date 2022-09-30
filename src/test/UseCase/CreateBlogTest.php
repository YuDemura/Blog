<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseInteractor\CreateBlogInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\NewBlog;
use App\Domain\Entity\User;
use App\Domain\InterfaceMapper\UserQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;

final class CreateBlogTest extends TestCase
{
    /**
     * @test
     */
    public function ブログ新規投稿をしようとしているユーザが存在する場合_trueが返ってくること():void
    {
        $input = new CreateBlogInput(
            new UserId(1),
            new Title('hoge'),
            new Contents('hoge')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserById(UserId $id): ?User
            {
                return new User (
                    new UserId(1),
                    new UserName('techquest'),
                    new Email('techquest@gmail.com'),
                    new HashedPassword('techquest1')
                );
            }
            public function findUserByMail(Email $email): ?User
            {
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
        };
        $interactor = new CreateBlogInteractor($input, $userQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function ブログ新規投稿をしようとしているユーザが存在しない場合_falseが返ってくること(): void
    {
        $input = new CreateBlogInput(
            new UserId(1),
            new Title('hoge'),
            new Contents('hoge')
        );

        $userQueryServiceInterface = new class implements UserQueryServiceInterface {
            public function findUserById(UserId $id): ?User
            {
                return null;
            }
            public function findUserByMail(Email $email): ?User
            {
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
        };

        $interactor = new CreateBlogInteractor($input, $userQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }
}
