<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseOutput\EditOutput;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;

final class EditInteractor
{
    /**
     * @var BlogQueryServiceInterface
     */
    private $blogQueryServiceInterface;

    /**
     * @var BlogRepositoryInterface
     */
    private $BlogRepositoryInterface;

    /**
     * @var EditInput
     */
    private $input;

    public function __construct(
        EditInput $input,
        BlogQueryServiceInterface $blogQueryServiceInterface,
        BlogRepositoryInterface $blogRepositoryInterface
        ) {
            $this->blogQueryServiceInterface = $blogQueryServiceInterface;
            $this->input = $input;
            $this->blogRepositoryInterface = $blogRepositoryInterface;
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
        return $this->blogQueryServiceInterface->findById($this->input->blog_id());
    }

    /**
     * 編集するブログ詳細を抽出
     * @return array | null
     */
    private function showBlog(): ?Blog
    {
        return $this->blogQueryServiceInterface->showDetail($this->input->user_id(), $this->input->blog_id());
    }

    /**
     * ブログを編集する
     *
     * @return void
     */
    private function update(): void
    {
        $this->BlogRepositoryInterface->updateBlog(
            new UpdateBlog(
                $this->input->blog_id(),
                $this->input->user_id(),
                $this->input->title(),
                $this->input->contents(),
            )
        );
    }
}
