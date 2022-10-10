<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewComment;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseOutput\CommentOutput;
use App\Domain\Entity\Blog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\CommentRepositoryInterface;



final class CommentInteractor
{
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepositoryInterface;

    /**
     * @var BlogQueryServiceInterface
     */
    private $blogQueryServiceInterface;

    /**
     * @var CommentInput
     */
    private $input;

    public function __construct(
        CommentInput $input,
        BlogQueryServiceInterface $blogQueryServiceInterface,
        CommentRepositoryInterface $commentRepositoryInterface
        )
    {
        $this->commentRepositoryInterface = $commentRepositoryInterface;
        $this->blogQueryServiceInterface = $blogQueryServiceInterface;
        $this->input = $input;
    }

    public function handler(): CommentOutput
    {
        $blog = $this->findBlog();
        if (!$blog) {
            return new CommentOutput(false);
        }

        $this->commentup();
        return new CommentOutput(true);
    }

    /**
     * 存在するブログかブログIDで検索する
     *
     * @return array | null
     */
    private function findBlog(): ?Blog
    {
        return $this->blogQueryServiceInterface->findById($this->input->blog_id());
    }

    /**
     * コメントを登録する
     *
     * @return void
     */
    private function commentup(): void
    {
        $this->commentRepositoryInterface->insert(
            new NewComment(
                $this->input->user_id(),
                $this->input->blog_id(),
                $this->input->commenter_name(),
                $this->input->comments(),
            )
        );
    }
}
