<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseOutput\CreateBlogOutput;
use App\Infrastructure\Dao\BlogDao;

final class CreateBlogInteractor
{
    private $input;

    public function __construct(CreateBlogInput $input)
    {
        $this->input = $input;
    }

    public function createBlog(): CreateBlogOutput
    {
      $session = Session::getInstance();
      $formInputs = $session->getFormInputs();
      $user_id = $formInputs['user_id'];

      $title = $this->input->title();
      $contents = $this->input->contents();

      $blogDao = new BlogDao();
      $blogDao->create($user_id, $title, $contents);
      return new CreateBlogOutput(true);
    }
}