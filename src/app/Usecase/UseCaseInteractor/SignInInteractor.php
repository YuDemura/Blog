<?php
namespace App\Usecase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../Infrastructure/Redirect/redirect.php';
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
        $user = $this->findUser();

        if ($this->notExistsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->isInvalidPassword($user['password'])) {
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

    private function isInvalidPassword(?string $password): bool
    {
        return !password_verify($this->input->password()->value(), $password);
    }

    private function saveSession(array $user): void
    {
        $session = Session::getInstance();
        $formInputs = [
        'user_id' => $user['id'],
        'name' => $user['name']
        ];
        $session->setFormInputs($formInputs);
    }
}
