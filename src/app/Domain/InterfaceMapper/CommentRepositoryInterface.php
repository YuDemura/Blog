<?php
namespace App\Domain\InterfaceMapper;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewComment;

interface CommentRepositoryInterface
{
    public function insert(NewComment $comment): void;
}
