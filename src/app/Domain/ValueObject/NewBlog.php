<?php

namespace App\Domain\ValueObject;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

/**
 * 新規投稿ブログのvalueObject
 */
final class NewBlog
{
    private $user_id;
    private $title;
    private $contents;

    public function __construct(UserId $user_id, Title $title, Contents $contents)
    {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->contents = $contents;
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
