<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseOutput\CreateBlogOutput;
use App\Adapter\Repository\BlogRepository;
use App\Domain\ValueObject\NewBlog;


final class CreateBlogInteractor
{
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

    public function createBlog(): CreateBlogOutput
    {
      $this->blogup();
      return new CreateBlogOutput(true);
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
