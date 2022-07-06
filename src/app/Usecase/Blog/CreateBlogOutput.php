<?php
namespace App\Usecase\Blog;

final class CreateBlogOutput
{
    private $isSuccess;

    public function __construct(bool $isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }
}
