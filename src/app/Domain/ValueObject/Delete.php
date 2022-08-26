<?php

namespace App\Domain\ValueObject;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\BlogId;

/**
 * ブログ削除のvalueObject
 */
final class Delete
{
    private $blog_id;

    public function __construct(BlogId $blog_id)
    {
        $this->blog_id = $blog_id;
    }

    public function blog_id(): BlogId
    {
        return $this->blog_id;
    }
}
