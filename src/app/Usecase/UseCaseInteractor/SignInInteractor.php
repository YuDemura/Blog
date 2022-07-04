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
    const EMPTY_MESSAGE = 'パスワードとメールアドレスを入力してください';

    private $userDao;
    private $input;

    public function __construct(SignInInput $input)
    {
        $this->userDao = new UserDao();
        $this->input = $input;
    }

    public function handler(): SignInOutput
    {
        $member = $this->findUser();

        if ($this->notExistsUser($member)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->isInvalidPassword($member['password'])) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->notFillOutForm($member['email'], $member['password'])) {
            return new SignInOutput(false, self::EMPTY_MESSAGE);
        }

        $this->saveSession($member);
        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    private function findUser(): ?array
    {
        return $this->userDao->findUserByMail($this->input->email());
    }

    private function notExistsUser(?array $member): bool
    {
        return is_null($member);
    }

    private function isInvalidPassword(string $password): bool
    {
        return !password_verify($this->input->password(), $password);
    }

    private function notFillOutForm(string $email, string $password): bool
    {
        return empty($this->input->email()) || empty($this->input->password());
    }

    private function saveSession(array $member): void
    {
        $session = Session::getInstance();
        $formInputs = [
        'user_id' => $member['id'],
        'name' => $member['name']
        ];
        $session->setFormInputs($formInputs);
    }
}
