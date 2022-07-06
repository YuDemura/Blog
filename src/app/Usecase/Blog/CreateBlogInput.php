<?php
namespace App\Usecase\Blog;

require_once __DIR__ . '/../../../vendor/autoload.php';

final class CreateBlogInput
{
    private $user_id;
    private $title;
    private $contents;

    public function __construct(string $user_id,string $title, string $contents)
    {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->contents = $contents;
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
