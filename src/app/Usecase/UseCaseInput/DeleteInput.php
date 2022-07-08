<?php
namespace App\Usecase\UseCaseInput;

final class DeleteInput
{
    private $user_id;
    private $blog_id;

    public function __construct(string $user_id, string $blog_id)
    {
        $this->user_id = $user_id;
        $this->blog_id = $blog_id;
    }

    public function user_id(): string
    {
        return $this->user_id;
    }

    public function blog_id(): string
    {
        return $this->blog_id;
    }
}
