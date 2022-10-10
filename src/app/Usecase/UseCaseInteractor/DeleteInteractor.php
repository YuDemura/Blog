<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseOutput\DeleteOutput;
use App\Domain\Entity\Blog;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;
use App\Domain\ValueObject\Delete;

final class DeleteInteractor
{
    /**
     * @var BlogQueryServiceInterface
     */
    private $blogQueryServiceInterface;

    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepositoryInterface;

    /**
     * @var DeleteInput
     */
    private $input;

    public function __construct(
      DeleteInput $input,
      BlogQueryServiceInterface $blogQueryServiceInterface,
      BlogRepositoryInterface $blogRepositoryInterface
      )
    {
        $this->blogQueryServiceInterface = $blogQueryServiceInterface;
        $this->blogRepositoryInterface = $blogRepositoryInterface;
        $this->input = $input;
    }

    public function handler(): DeleteOutput
    {
      $blog = $this->findBlog();

      if (!$blog) {
        return new DeleteOutput(false);
      }

      $this->deleteBlog();
      return new DeleteOutput(true);
    }

    /**
     * 存在するブログかブログIDで検索する
     * @return array | null
     */
    private function findBlog(): ?Blog
    {
        return $this->blogQueryServiceInterface->findById($this->input->blog_id());
    }

    /**
     * ブログを削除する
     * @return void
     */
    private function deleteBlog(): void
    {
        $this->blogRepositoryInterface->delete(new Delete($this->input->blog_id())
        );
    }
}
