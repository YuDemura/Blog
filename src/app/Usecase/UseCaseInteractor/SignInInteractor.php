<?php
namespace App\Usecase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
require_once __DIR__ . '/../../Infrastructure/Redirect/redirect.php';
use App\Domain\Entity\User;
use App\Domain\ValueObject\HashedPassword;
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseOutput\SignInOutput;
use App\Adapter\QueryService\UserQueryService;

final class SignInInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたは<br />パスワードが間違っています';
    const SUCCESS_MESSAGE = 'ログインしました';

    private $userQueryService;
    private $input;

    public function __construct(SignInInput $input)
    {
        $this->userQueryService = new UserQueryService();
        $this->input = $input;
    }

    public function handler(): SignInOutput
    {
        $user = $this->findUser();

        if ($this->notExistsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->isInvalidPassword($user->password())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);
        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    private function findUser(): ?User
    {
        return $this->userQueryService->findUserByMail($this->input->email());
    }

    private function notExistsUser(?User $user): bool
    {
        return is_null($user);
    }

    private function isInvalidPassword(HashedPassword $hashedPassword): bool
    {
        return !$hashedPassword->verify($this->input->password());
    }

    private function saveSession(User $user): void
    {
        $session = Session::getInstance();
        $formInputs = [
        'user_id' => $user->id(),
        'name' => $user->name()
        ];
        $session->setFormInputs($formInputs);
    }
}
