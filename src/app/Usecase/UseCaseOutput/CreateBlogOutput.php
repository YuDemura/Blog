<?php
namespace App\Usecase\UseCaseOutput;

final class CreateBlogOutput
{
    private $isSuccess;
    // private $message;

    public function __construct(bool $isSuccess)
    {
        $this->isSuccess = $isSuccess;
        // $this->message = $message;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    // public function message(): string
    // {
    //     return $this->message;
    // }
}
