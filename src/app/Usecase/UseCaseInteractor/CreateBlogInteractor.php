<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseOutput\CreateBlogOutput;
use App\Domain\ValueObject\NewBlog;
use App\Domain\Entity\User;
use App\Domain\InterfaceMapper\UserQueryServiceInterface;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;

final class CreateBlogInteractor
{
    /**
     * @var BlogRepositoryInterface
     */
    private $blogRepositoryInterface;

    /**
     * @var UserQueryServiceInterface
     */
    private $userQueryServiceInterface;

    /**
     * @var CreateBlogInput
     */
    private $input;

    public function __construct(
        CreateBlogInput $input,
        UserQueryServiceInterface $userQueryServiceInterface,
        BlogRepositoryInterface $blogRepositoryInterface
        ) {
            $this->blogRepositoryInterface = $blogRepositoryInterface;
            $this->userQueryServiceInterface = $userQueryServiceInterface;
            $this->input = $input;
        }

    public function handler(): CreateBlogOutput
    {
        $user = $this->findUser();
        if (!$user) {
            return new CreateBlogOutput(false);
        }

        $this->blogup();
        return new CreateBlogOutput(true);
    }

    private function blogup(): void
    {
        $this->blogRepositoryInterface->insert(
            new NewBlog(
                $this->input->user_id(),
                $this->input->title(),
                $this->input->contents()
            )
        );
    }

    /**
     * ブログ新規投稿をしようとしているユーザが存在するか
     * @return array | null
     */
    private function findUser(): ?User
    {
        return $this->userQueryServiceInterface->findUserById($this->input->user_id());
    }
}
