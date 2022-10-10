<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewBlog;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\ValueObject\Delete;

interface BlogRepositoryInterface
{
    public function insert(NewBlog $blog): void;

    public function updateBlog(UpdateBlog $blog): void;

    public function delete(Delete $blog): void;
}
