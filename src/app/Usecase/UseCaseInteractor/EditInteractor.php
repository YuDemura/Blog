<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseOutput\EditOutput;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\UpdateBlog;
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\BlogRepository;

final class EditInteractor
{
    /**
     * @var BlogQueryService
     */
    private $blogQueryService;

    /**
     * @var BlogRepository
     */
    private $BlogRepository;

    /**
     * @var EditInput
     */
    private $input;

    public function __construct(EditInput $input)
    {
      $this->blogQueryService = new BlogQueryService();
      $this->input = $input;
      $this->BlogRepository = new BlogRepository();
    }

    public function handler(): EditOutput
    {
        $user_id = $this->input->user_id()->value();
        $user = $this->getUser();
        $editUser = $user->userId()->value();
        if ($editUser !== $user_id) {
            return new EditOutput(false);
        }

        $blogs = $this->showBlog();
        $this->update();
        return new EditOutput(true);
    }

    /**
     * ブログID=XXの記事をDBから取得し、その記事を書いた人のユーザIDを取得
     * @return array | null
     */
    private function getUser(): ?Blog
    {
        return $this->blogQueryService->findById($this->input->blog_id());
    }

    /**
     * 編集するブログ詳細を抽出
     * @return array | null
     */
    private function showBlog(): ?Blog
    {
        return $this->blogQueryService->showDetail($this->input->user_id(), $this->input->blog_id());
    }

    /**
     * ブログを編集する
     *
     * @return void
     */
    private function update(): void
    {
        $this->BlogRepository->updateBlog(
            new UpdateBlog(
                $this->input->blog_id(),
                $this->input->user_id(),
                $this->input->title(),
                $this->input->contents(),
            )
        );
    }
}
