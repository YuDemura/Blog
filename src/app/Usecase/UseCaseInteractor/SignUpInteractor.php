<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseOutput\SignUpOutput;
use App\Domain\ValueObject\NewUser;
use App\Domain\Entity\User;
use App\Domain\InterfaceMapper\UserQueryServiceInterface;
use App\Domain\InterfaceMapper\UserRepositoryInterface;

final class SignUpInteractor
{
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';
    const COMPLETED_MESSAGE = '登録が完了しました';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepositoryInterface;

    /**
     * @var UserQueryServiseInterface
     */
    private $userQueryServiceInterface;

    /**
     * @var SignUpInput
     */
    private $input;

    /**
     * コンストラクタ
     *
     * @param SignUpInput $input
     */
    public function __construct(
        SignUpInput $input,
        UserQueryServiceInterface $userQueryServiceInterface,
        UserRepositoryInterface $userRepositoryInterface
        ) {
            $this->userRepositoryInterface = $userRepositoryInterface;
            $this->userQueryServiceInterface = $userQueryServiceInterface;
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
        return $this->userQueryServiceInterface->findUserByMail($this->input->email());
    }

    private function existsUser(?User $user): bool
    {
        return !is_null($user);
    }

    private function signup(): void
    {
        $this->userRepositoryInterface->insert(
            new NewUser(
                $this->input->name(),
                $this->input->email(),
                $this->input->password()
            )
        );
    }
}
