<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseOutput\DeleteOutput;
use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Lib\Session;


final class DeleteInteractor
{
    private $input;

    public function __construct(DeleteInput $input)
    {
        $this->input = $input;
    }

    public function run(): DeleteOutput
    {
      $session = Session::getInstance();
      $formInputs = $session->getFormInputs();
      $user_id = $formInputs['user_id'];

      $blogDao = new BlogDao();
      $blog = $blogDao->findBlogByBlogId($this->input->blog_id()->value());

      if (!$blog) {
        return new DeleteOutput(false);
      }

      $blogs = $blogDao->showDetail($user_id->value(), $this->input->blog_id()->value());

      $blogEntity = $this->buildBlogEntity($blogs);
      $blogDao->delete($blogEntity->blogId()->value());
      return new DeleteOutput(true);
    }

    private function buildBlogEntity(array $blogEntityEx): Blog
    {
      return new Blog(
        new BlogId($blogEntityEx['id']),
        new UserId($blogEntityEx['user_id']),
        new Title($blogEntityEx['title']),
        new Contents($blogEntityEx['contents'])
      );
    }
}
