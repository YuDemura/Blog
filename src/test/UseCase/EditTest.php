<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseInteractor\EditInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\ValueObject\NewBlog;
use App\Domain\Entity\Blog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;
use App\Domain\ValueObject\BlogId;

final class EditTest extends TestCase
{
    /**
     * @test
     */
    public function ログイン中のユーザーと、ブログ記事を書いたユーザーが一致している場合_trueが返ってくること():void
    {
        $input = new EditInput(
            new BlogId(1),
            new UserId(1),
            new Title('hoge'),
            new Contents('hoge')
        );

        $blogQueryServiceInterface = new class implements BlogQueryServiceInterface {
            public function findById(BlogId $blogId): ?Blog
            {
                return new Blog (
                    new BlogId(1),
                    new UserId(1),
                    new Title('hoge'),
                    new Contents('hoge')
                );
            }
            public function showDetail(UserId $userId, BlogId $blogId): ?Blog
            {
                return new Blog(
                    new BlogId(1),
                    new UserId(1),
                    new Title('hoge'),
                    new Contents('hoge')
                );
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
            public function updateBlog(UpdateBlog $blog): void
            {
            }
        };
        $interactor = new EditInteractor($input, $blogQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function ログイン中のユーザーと、ブログ記事を書いたユーザーが一致していない場合_falseが返ってくること(): void
    {
        $input = new EditInput(
            new BlogId(1),
            new UserId(1),
            new Title('hoge'),
            new Contents('hoge')
        );


        $blogQueryServiceInterface = new class implements BlogQueryServiceInterface {
            public function findById(BlogId $blogId): ?Blog
            {
                return new Blog (
                    new BlogId(1),
                    new UserId(2),
                    new Title('hoge'),
                    new Contents('hoge')
                );
            }
            public function showDetail(UserId $userId, BlogId $blogId): ?Blog
            {
                return new Blog(
                    new BlogId(1),
                    new UserId(2),
                    new Title('hoge'),
                    new Contents('hoge')
                );
            }
        };

        $blogRepositoryInterface = new class implements BlogRepositoryInterface {
            public function insert(NewBlog $blog): void
            {
            }
            public function updateBlog(UpdateBlog $blog): void
            {
            }
        };
        $interactor = new EditInteractor($input, $blogQueryServiceInterface, $blogRepositoryInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());


    }
}
