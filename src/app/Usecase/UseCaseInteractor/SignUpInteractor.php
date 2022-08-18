<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseOutput\SignUpOutput;
use App\Adapter\QueryService\UserQueryService;
use App\Adapter\Repository\UserRepository;
use App\Domain\ValueObject\NewUser;
use App\Domain\Entity\User;

final class SignUpInteractor
{
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';
    const COMPLETED_MESSAGE = '登録が完了しました';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserQueryServise
     */
    private $userQueryService;

    /**
     * @var SignUpInput
     */
    private $input;

    public function __construct(SignUpInput $input)
    {
        $this->userRepository = new UserRepository();
        $this->userQueryService = new UserQueryService();
        $this->input = $input;
    }

    public function handler(): SignUpOutput
    {
        $user = $this->findUser();
        if ($this->existsUser($user)) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $this->signup();
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
    }

    private function findUser(): ?User
    {
        return $this->userQueryService->findUserByMail($this->input->email());
    }

    private function existsUser(?User $user): bool
    {
        return !is_null($user);
    }

    private function signup(): void
    {
        $this->userRepository->insert(
            new NewUser(
                $this->input->name(),
                $this->input->email(),
                $this->input->password()
            )
        );
    }
}
