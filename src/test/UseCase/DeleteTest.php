<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseInteractor\DeleteInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\ValueObject\NewBlog;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\ValueObject\Delete;
use App\Domain\Entity\Blog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;

final class DeleteTest extends TestCase
{
    /**
     * @test
     */
    public function 存在するブログを削除する場合_trueが返ってくること():void
    {
        $input = new DeleteInput(
            new BlogId('1')
        );

        $blogQueryServiceInterface = new class implements BlogQueryServiceInterface {
            public function findById(BlogId $id): ?Blog
            {
                return new Blog (
                    new BlogId(1),
                    new UserId(1),
                    new Title('hoge'),
                    new contents('hoge'),
                );
            }
            public function showDetail(UserId $userId, BlogId $blogId): ?Blog
            {
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
            public function updateBlog(UpdateBlog $blog): void
            {
            }
            public function delete(Delete $blog): void
            {
            }
        };
        $interactor = new DeleteInteractor($input, $blogQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function 存在しないブログを削除しようとした場合_falseが返ってくること(): void
    {
        $input = new DeleteInput(
            new BlogId('1')
        );

        $blogQueryServiceInterface = new class implements BlogQueryServiceInterface {
            public function findById(BlogId $id): ?Blog
            {
                return null;
            }
            public function showDetail(UserId $userId, BlogId $blogId): ?Blog
            {
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
            public function updateBlog(UpdateBlog $blog): void
            {
            }
            public function delete(Delete $blog): void
            {
            }
        };

        $interactor = new DeleteInteractor($input, $blogQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }
}
