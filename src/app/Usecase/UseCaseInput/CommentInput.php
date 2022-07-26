<?php
namespace App\Usecase\UseCaseInput;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommenterName;
use App\Domain\ValueObject\Comments;

final class CommentInput
{
    private $user_id;
    private $blog_id;
    private $commenter_name;
    private $comments;

    public function __construct(UserId $user_id,BlogId $blog_id, CommenterName $commenter_name, Comments $comments)
    {
        $this->user_id = $user_id;
        $this->blog_id = $blog_id;
        $this->commenter_name = $commenter_name;
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

    public function commenter_name(): CommenterName
    {
        return $this->commenter_name;
    }

    public function comments(): Comments
    {
        return $this->comments;
    }
}
