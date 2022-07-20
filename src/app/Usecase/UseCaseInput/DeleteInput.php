<?php
namespace App\Usecase\UseCaseInput;

use App\Domain\ValueObject\BlogId;


final class DeleteInput
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
