<?php
namespace App\Usecase\UseCaseInteractor;

require_once __DIR__ . '/../../../vendor/autoload.php';
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
        $user = $userDao->findUserByMail($this->useCaseInput->email()->value());
        if ($user) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $userDao->createUser(
            $this->useCaseInput->name()->value(),
            $this->useCaseInput->email()->value(),
            $this->useCaseInput->password()->value()
        );
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
    }
}
