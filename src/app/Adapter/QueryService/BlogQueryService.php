<?php

namespace App\Adapter\QueryService;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

final class BlogQueryService
{
    /**
     * @var BlogDao
     */
    private $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogDao();
    }

    public function findBlogByBlog_id(BlogId $blogId): ?Blog
    {
        $blogMapper = $this->blogDao->findBlogByBlog_id($blogId->value());

        return $this->notExistsBlog($blogMapper)
            ? null
            : new Blog(
                new BlogId($blogMapper['id']),
                new UserId($blogMapper['user_id']),
                new Title($blogMapper['title']),
                new Contents($blogMapper['contents']),
            );
    }

    private function notExistsBlog(?array $blog): bool
    {
        return is_null($blog);
    }
}
