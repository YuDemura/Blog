<?php

namespace App\Adapter\QueryService;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\UserDao;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

final class UserQueryService
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function findUserByMail(Email $email): ?User
    {
        $userMapper = $this->userDao->findUserByMail($email->value());

        return $this->notExistsUser($userMapper)
            ? null
            : new User(
                new UserId($userMapper['id']),
                new UserName($userMapper['name']),
                new Email($userMapper['email']),
                new HashedPassword($userMapper['password'])
            );
    }

    private function notExistsUser(?array $user): bool
    {
        return is_null($user);
    }
}
