<?php

namespace App\Domain\ValueObject;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommenterName;
use App\Domain\ValueObject\Comments;

/**
 * 新規投稿コメントのvalueObject
 */
final class NewComment
{
    private $user_id;
    private $blog_id;
    private $commenterName;
    private $comments;

    public function __construct(UserId $user_id, BlogId $blog_id, CommenterName $commenterName, Comments $comments)
    {
        $this->user_id = $user_id;
        $this->blog_id = $blog_id;
        $this->commenterName = $commenterName;
        $this->comments = $comments;
    }

    public function user_id(): UserId
    {
        return $this->user_id;
    }

    public function blog_id(): BlogId
    {
        return $this->blog_id;
    }

    public function commenterName(): CommenterName
    {
        return $this->commenterName;
    }

    public function comments(): Comments
    {
        return $this->comments;
    }
}
