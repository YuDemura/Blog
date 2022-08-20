<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseOutput\CreateBlogOutput;
use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\NewBlog;

final class CreateBlogInteractor
{
    const FAILED_MESSAGE_TITLE = 'タイトルを入力して下さい';
    const FAILED_MESSAGE_CONTENTS = 'ブログ内容を入力して下さい';

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * @var CreateBlogInput
     */
    private $input;

    public function __construct(CreateBlogInput $input)
    {
        $this->blogRepository = new BlogRepository();
        $this->input = $input;
    }

    public function handler(): CreateBlogOutput
    {
        if ($this->notFilloutTitle()) {
            return new CreateBlogOutput(false, self::FAILED_MESSAGE_TITLE);
        }

        if ($this->notFilloutContents()) {
            return new CreateBlogOutput(false, self::FAILED_MESSAGE_CONTENTS);
        }

        $this->blogup();
        return new CreateBlogOutput(true);
    }

    private function notFilloutTitle(): bool
    {
        return empty($this->input->title()->value());
    }

    private function notFilloutContents(): bool
    {
        return empty($this->input->contents()->value());
    }

    private function blogup(): void
    {
        $this->blogRepository->insert(
            new NewBlog(
                $this->input->user_id(),
                $this->input->title(),
                $this->input->contents()
            )
        );
    }
}
