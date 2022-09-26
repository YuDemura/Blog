<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\UserId;
use App\Domain\Entity\User;

interface UserQueryServiceInterface
{
    public function findUserByMail(Email $email): ?User;

    public function findUserById(UserId $id): ?User;
}
