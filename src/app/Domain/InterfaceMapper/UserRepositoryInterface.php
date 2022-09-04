<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewUser;

interface UserRepositoryInterface
{
  public function insert(NewUser $user): void;
}
