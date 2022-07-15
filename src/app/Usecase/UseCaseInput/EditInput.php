<?php
namespace App\Usecase\UseCaseInput;

final class EditInput
{
    private $blog_id;
    private $user_id;
    private $title;
    private $contents;

    public function __construct(string $blog_id, string $user_id, string $title, string $contents)
    {
        $this->blog_id = $blog_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->contents = $contents;
    }

    public function blog_id(): string
    {
        return $this->blog_id;
    }

    public function user_id(): string
    {
        return $this->user_id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function contents(): string
    {
        return $this->contents;
    }
}
