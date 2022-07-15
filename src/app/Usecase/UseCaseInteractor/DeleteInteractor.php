<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\DeleteInput;
use App\Usecase\UseCaseOutput\DeleteOutput;
use App\Infrastructure\Dao\BlogDao;

final class DeleteInteractor
{
    private $input;

    public function __construct(DeleteInput $input)
    {
        $this->input = $input;
    }

    public function run(): DeleteOutput
    {
      $blog_id = $this->input->blog_id();

      $blogDao = new BlogDao();
      $blog = $blogDao->findBlogByBlog_id($this->input->blog_id());

      if (!$blog) {
        return new DeleteOutput(false);
      }

      $blogDao = new BlogDao();
      $blogDao->delete($blog_id);
      return new DeleteOutput(true);
    }
}
