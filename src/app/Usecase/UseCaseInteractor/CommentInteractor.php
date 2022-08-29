<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\CommentRepository;
use App\Domain\ValueObject\NewComment;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseOutput\CommentOutput;
use App\Domain\Entity\Blog;

final class CommentInteractor
{
    const FAILED_MESSAGE_COMMENTER_NAME = 'コメント名を入力して下さい';
    const FAILED_MESSAGE_COMMENTS = 'コメント内容を入力して下さい';
    const FAILED_MESSAGE_NOT_EXISTED = 'ブログが存在しません';
    const SUCCESS_MESSAGE = 'コメント投稿しました';
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
        $errors = [];
        if (!$blog) {
            $errors[] = self::FAILED_MESSAGE_NOT_EXISTED;
        }

        if ($this->notFilloutCommenterName()) {
            $errors[] = self::FAILED_MESSAGE_COMMENTER_NAME;
        }

        if ($this->notFilloutComments()) {
            $errors[] = self::FAILED_MESSAGE_COMMENTS;
        }

        if (!empty($errors)) {
            return new CommentOutput(false, $errors);
        }

        $success = [];
        $this->commentup();
        $success[] = self::SUCCESS_MESSAGE;
        return new CommentOutput(true, $success);
    }

    /**
     * 存在するブログかブログIDで検索する
     *
     * @return array | null
     */
    private function findBlog(): ?Blog
    {
        return $this->blogQueryService->findById($this->input->blog_id());
    }

    private function notFilloutCommenterName(): bool
    {
        return empty($this->input->commenter_name()->value());
    }

    private function notFilloutComments(): bool
    {
        return empty($this->input->comments()->value());
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
