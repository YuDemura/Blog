<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\BlogDao;
use App\Domain\ValueObject\NewBlog;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\ValueObject\Delete;
use App\Domain\InterfaceMapper\BlogRepositoryInterface;


final class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var BlogDao
     */
    private $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogDao();
    }

    public function insert(NewBlog $blog): void
    {
        $this->blogDao->create($blog);
    }

    public function updateBlog(UpdateBlog $blog): void
    {
        $this->blogDao->update($blog);
    }

    public function delete(Delete $blog): void
    {
        $this->blogDao->delete($blog);
    }
}
