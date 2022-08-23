<?php
namespace App\Usecase\UseCaseOutput;

final class CreateBlogOutput
{
    private $isSuccess;
    private $message;

    public function __construct(bool $isSuccess, array $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function message(): array
    {
        return $this->message;
    }
}
