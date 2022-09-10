<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\CreateBlogInput;
use App\Usecase\UseCaseOutput\CreateBlogOutput;
use App\Adapter\Repository\BlogRepository;
use App\Adapter\QueryService\UserQueryService;
use App\Domain\ValueObject\NewBlog;
use App\Domain\Entity\User;

final class CreateBlogInteractor
{
    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * @var UserQueryService
     */
    private $userQueryService;

    /**
     * @var CreateBlogInput
     */
    private $input;

    public function __construct(CreateBlogInput $input)
    {
        $this->blogRepository = new BlogRepository();
        $this->userQueryService = new UserQueryService();
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
        $this->blogRepository->insert(
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
        return $this->userQueryService->findUserById($this->input->user_id());
    }
}
