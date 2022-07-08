<?php
namespace App\Usecase\UseCaseOutput;

final class EditOutput
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
