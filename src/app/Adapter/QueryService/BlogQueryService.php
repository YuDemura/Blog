<?php

namespace App\Adapter\QueryService;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\Domain\InterfaceMapper\BlogQueryServiceInterface;


final class BlogQueryService implements BlogQueryServiceInterface
{
    /**
     * @var BlogDao
     */
    private $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogDao();
    }

    public function findById(BlogId $blogId): ?Blog
    {
        $blogMapper = $this->blogDao->findById($blogId->value());

        return $this->notExistsBlog($blogMapper)
            ? null
            : new Blog(
                new BlogId($blogMapper['id']),
                new UserId($blogMapper['user_id']),
                new Title($blogMapper['title']),
                new Contents($blogMapper['contents']),
            );
    }

    public function showDetail(UserId $user_id, BlogId $blogId): ?Blog
    {
        $blogMapperRead = $this->blogDao->showDetail($user_id->value(),
        $blogId->value());

        return $this->notExistsBlog($blogMapperRead)
            ? null
            : new Blog(
                new BlogId($blogMapperRead['id']),
                new UserId($blogMapperRead['user_id']),
                new Title($blogMapperRead['title']),
                new Contents($blogMapperRead['contents']),
            );
    }

    private function notExistsBlog(?array $blog): bool
    {
        return is_null($blog);
    }
}
