<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\BlogId;
use App\Domain\Entity\Blog;

interface BlogQueryServiceInterface
{
    public function findById(BlogId $blogId): ?Blog;
}
