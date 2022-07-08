<?php
namespace App\Usecase\CommentInput;

require_once __DIR__ . '/../../../vendor/autoload.php';

final class CommentInput
{
    private $user_id;
    private $blog_id;
    private $commenter_name;
    private $comments;

    public function __construct(string $user_id,string $blog_id, string $commenter_name, string $comments)
    {
        $this->user_id = $user_id;
        $this->blog_id = $blog_id;
        $this->commenter_name = $commenter_name;
        $this->comments = $comments;
    }

    public function user_id(): string
    {
        return $this->user_id;
    }

    public function blog_id(): string
    {
        return $this->blog_id;
    }

    public function commenter_name(): string
    {
        return $this->commenter_name;
    }

    public function comments(): string
    {
        return $this->comments;
    }
}
