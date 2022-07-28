<?php
namespace App\Usecase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../Infrastructure/Redirect/redirect.php';
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Usecase\UseCaseInput\SignInInput;
use App\Usecase\UseCaseOutput\SignInOutput;
use App\Infrastructure\Dao\UserDao;

final class SignInInteractor
{
    const FAILED_MESSAGE = 'メールアドレスまたは<br />パスワードが間違っています';
    const SUCCESS_MESSAGE = 'ログインしました';

    private $userDao;
    private $input;

    public function __construct(SignInInput $input)
    {
        $this->userDao = new UserDao();
        $this->input = $input;
    }

    public function handler(): SignInOutput
    {
        $userMapper = $this->findUser();

        if ($this->notExistsUser($userMapper)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $user = $this->buildUserEntity($userMapper);

        if ($this->isInvalidPassword($user->password()->value())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);
        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    private function findUser()
    {
        return $this->userDao->findUserByMail($this->input->email()->value());
    }

    private function notExistsUser($user): bool
    {
        return is_null($user);
    }

    private function buildUserEntity(array $user): User
    {
        return new User(
            new UserId($user['id']),
            new UserName($user['name']),
            new Email($user['email']),
            new HashedPassword($user['password']));
    }

    private function isInvalidPassword(?string $password): bool
    {
        return !password_verify($this->input->password()->value(), $password);
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
