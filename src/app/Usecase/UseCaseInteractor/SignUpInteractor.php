<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Lib\Session;
use App\Lib\SessionKey;
require_once __DIR__ . '/../../Infrastructure/Redirect/redirect.php';
use App\Usecase\UseCaseInput\SignUpInput;
use App\Usecase\UseCaseOutput\SignUpOutput;
use App\Infrastructure\Dao\UserDao;

final class SignUpInteractor
{
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';
    const COMPLETED_MESSAGE = '登録が完了しました';

    private $useCaseInput;

    public function __construct(SignUpInput $useCaseInput)
    {
        $this->useCaseInput = $useCaseInput;
    }

    public function handler(): SignUpOutput
    {
        $userDao = new UserDao();
        $member = $userDao->findUserByMail($this->useCaseInput->email());

        if ($member) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
            redirect('signup.php');
        }

        $userDao->createUser(
            $this->useCaseInput->name(),
            $this->useCaseInput->email(),
            $this->useCaseInput->password()
        );
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
        redirect('signin.php');
    }
}
