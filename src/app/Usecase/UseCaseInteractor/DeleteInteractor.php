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

    public function deleteBlog(): DeleteOutput
    {
      $session = Session::getInstance();
      $formInputs = $session->getFormInputs();
      $user_id = $formInputs['user_id'];

      $blog_id = $this->input->blog_id();

      $blogDao = new BlogDao();
      $blogDao->delete($user_id, $blog_id);
      return new DeleteOutput(true);
    }
}
