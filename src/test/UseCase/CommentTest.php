<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseInteractor\CommentInteractor;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommenterName;
use App\Domain\ValueObject\comments;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\ValueObject\NewBlog;
use App\Domain\ValueObject\NewComment;
use App\Domain\Entity\Blog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\CommentRepositoryInterface;

final class CommentTest extends TestCase
{
    /**
     * @test
     */
    public function 存在するブログに投稿する場合_trueが返ってくること():void
    {
        $input = new CommentInput(
            new UserId(1),
            new BlogId('1'),
            new CommenterName('hoge'),
            new Comments('hoge')
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
        };

        $commentRepositoryInterface = new class implements CommentRepositoryInterface {
            public function insert(NewComment $comment): void
            {
            }
        };
        $interactor = new CommentInteractor($input, $blogQueryServiceInterface, $commentRepositoryInterface);
        $this->assertSame(true, $interactor->handler()->isSuccess());
    }

    /**
     * @test
     */
    public function 存在しないブログに投稿しようとした場合_falseが返ってくること(): void
    {
        $input = new CommentInput(
            new UserId(1),
            new BlogId('1'),
            new CommenterName('hoge'),
            new Comments('hoge')
        );

        $blogQueryServiceInterface = new class implements BlogQueryServiceInterface {
            public function findById(BlogId $id): ?Blog
            {
                return null;
            }
        };

        $commentRepositoryInterface = new class implements CommentRepositoryInterface {
            public function insert(NewComment $comment): void
            {
            }
        };

        $interactor = new CommentInteractor($input, $blogQueryServiceInterface, $commentRepositoryInterface);
        $this->assertSame(false, $interactor->handler()->isSuccess());
    }
}
