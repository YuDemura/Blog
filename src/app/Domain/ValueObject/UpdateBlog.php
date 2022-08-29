<?php

namespace App\Domain\ValueObject;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

/**
 * 編集BlogのvalueObject
 */
final class UpdateBlog
{
    private $blog_id;
    private $user_id;
    private $title;
    private $contents;

    public function __construct(BlogId $blog_id, UserId $user_id, Title $title, Contents $contents)
    {
        $this->blog_id = $blog_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->contents = $contents;
    }

    public function blog_id(): BlogId
    {
        return $this->blog_id;
    }

    public function user_id(): UserId
    {
        return $this->user_id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function contents(): Contents
    {
        return $this->contents;
    }
}
