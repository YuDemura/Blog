<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\NewUser;
use App\Domain\InterfaceMapper\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function insert(NewUser $user): void
    {
        $this->userDao->create($user);
    }
}
