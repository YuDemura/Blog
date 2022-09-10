<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\CommentRepository;
use App\Domain\ValueObject\NewComment;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseOutput\CommentOutput;
use App\Domain\Entity\Blog;

final class CommentInteractor
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var BlogQueryService
     */
    private $blogQueryService;

    /**
     * @var CommentInput
     */
    private $input;

    public function __construct(CommentInput $input)
    {
        $this->commentRepository = new CommentRepository();
        $this->blogQueryService = new BlogQueryService();
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
        return $this->blogQueryService->findBlogByBlogId($this->input->blog_id());
    }

    /**
     * コメントを登録する
     *
     * @return void
     */
    private function commentup(): void
    {
        $this->commentRepository->insert(
            new NewComment(
                $this->input->user_id(),
                $this->input->blog_id(),
                $this->input->commenter_name(),
                $this->input->comments(),
            )
        );
    }
}
