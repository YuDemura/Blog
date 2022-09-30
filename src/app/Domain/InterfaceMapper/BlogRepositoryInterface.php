<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewBlog;

interface BlogRepositoryInterface
{
    public function insert(NewBlog $blog): void;
}
