<?php
namespace App\Domain\Entity;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\CommentId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommenterName;
use App\Domain\ValueObject\Comments;

/**
 * コメントのEntity
 */
final class Comment
{
    /**
     * @var CommentId
     */
    private $commentId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var BlogId
     */
    private $blogId;

    /**
     * @var CommenterName
     */
    private $commenterName;

    /**
     * @var Comments
     */
    private $comments;

    /**
     * コンストラクタ
     * @param CommentId $commentId
     * @param UserId $userId
     * @param BlogId $blogId
     * @param CommenterName $commenterName
     * @param Comments $comments
     */
    public function __construct(
        CommentId $commentId,
        UserId $userId,
        BlogId $blogId,
        CommenterName $commenterName,
        Comments $comments
    ) {
        $this->commentId = $commentId;
        $this->userId = $userId;
        $this->blogId = $blogId;
        $this->commenterName = $commenterName;
        $this->comments = $comments;
    }

    /**
     * @return CommentId
     */
    public function commentId(): CommentId
    {
        return $this->commentId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return BlogId
     */
    public function blogId(): BlogId
    {
        return $this->blogId;
    }

    /**
     * @return CommenterName
     */
    public function commenterName(): CommenterName
    {
        return $this->commenterName;
    }

    /**
     * @return Comments
     */
    public function comments(): Comments
    {
        return $this->comments;
    }
}
