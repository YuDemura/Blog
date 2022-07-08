<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseOutput\EditOutput;
use App\Infrastructure\Dao\BlogDao;

final class EditInteractor
{
    private $input;

    public function __construct(EditInput $input)
    {
        $this->input = $input;
    }

    public function updateBlog(): EditOutput
    {
        $session = Session::getInstance();
        $formInputs = $session->getFormInputs();
        $user_id = $formInputs['user_id'];

        $blog_id = $this->input->blog_id();
        $title = $this->input->title();
        $contents = $this->input->contents();

        $blogDao = new BlogDao();
        $blogDao->update($blog_id, $user_id, $title, $contents);
        return new EditOutput(true);
    }
}
