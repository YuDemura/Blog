<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseOutput\DeleteOutput;
use App\Domain\Entity\Blog;
use App\Lib\Session;
use App\Adapter\QueryService\BlogQueryService;
use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\Delete;

final class DeleteInteractor
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
     * @var DeleteInput
     */
    private $input;

    public function __construct(DeleteInput $input)
    {
        $this->blogQueryService = new BlogQueryService();
        $this->BlogRepository = new BlogRepository();
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
        return $this->blogQueryService->findBlogByBlogId($this->input->blog_id());
    }

    /**
     * ブログを削除する
     * @return void
     */
    private function deleteBlog(): void
    {
        $this->BlogRepository->delete(new Delete($this->input->blog_id())
        );
    }
}
