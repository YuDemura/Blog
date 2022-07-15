<?php
namespace App\Usecase\UseCaseInput;

final class DeleteInput
{
    private $blog_id;

    public function __construct(string $blog_id)
    {
        $this->blog_id = $blog_id;
    }

    public function blog_id(): string
    {
        return $this->blog_id;
    }
}
