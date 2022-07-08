<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\CommentInput;
use App\Usecase\UseCaseOutput\CommentOutput;
use App\Infrastructure\Dao\CommentDao;

final class CommentInteractor
{
    private $input;

    public function __construct(CommentInput $input)
    {
        $this->input = $input;
    }

    public function post(): CommentOutput
    {
        $session = Session::getInstance();
        $formInputs = $session->getFormInputs();
        $user_id = $formInputs['user_id'];

        $blog_id = $this->input->blog_id();
        $commenter_name = $this->input->commenter_name();
        $comments = $this->input->comments();

        $commentDao = new CommentDao();
        $commentDao->postComment($user_id, $blog_id, $commenter_name, $comments);
        return new CommentOutput(true);
    }
}
