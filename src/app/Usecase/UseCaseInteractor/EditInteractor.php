<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Usecase\UseCaseInput\EditInput;
use App\Usecase\UseCaseOutput\EditOutput;
use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

final class EditInteractor
{
    private $input;

    public function __construct(EditInput $input)
    {
        $this->input = $input;
    }

    public function run(): EditOutput
    {
        $session = Session::getInstance();
        $formInputs = $session->getFormInputs();
        $user_id = $formInputs['user_id'];

        $title = $this->input->title()->value();
        $contents = $this->input->contents()->value();

        $blogDao = new BlogDao();
        $user = $blogDao->getUserByBlog($this->input->blog_id()->value());
        $editUser = $user["user_id"];

        if ($editUser !== $user_id->value()) {
            return new EditOutput(false);
        }

        $blogs = $blogDao->showDetail($user_id->value(), $this->input->blog_id()->value());

        $blogEntity = $this->buildBlogEntity($blogs);

        $blogDao->update($blogEntity->blogId()->value(), $user_id->value(), $title, $contents);
        return new EditOutput(nnsuumetrue);
    }

    private function buildBlogEntity(array $blogEntity): Blog
    {
      return new Blog(
        new BlogId($blogEntity['id']),
        new UserId($blogEntity['user_id']),
        new Title($blogEntity['title']),
        new Contents($blogEntity['contents'])
      );
    }
}
