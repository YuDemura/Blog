<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\CommentDao;
use App\Domain\ValueObject\NewComment;
use App\Domain\InterfaceMapper\CommentRepositoryInterface;

final class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var CommentDao
     */
    private $commentDao;

    public function __construct()
    {
        $this->commentDao = new CommentDao();
    }

    public function insert(NewComment $comment): void
    {
        $this->commentDao->postComment($comment);
    }
}
