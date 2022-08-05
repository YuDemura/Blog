<?php
namespace App\Domain\Entity;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

/**
 * ブログのEntity
 */
final class Blog
{
    /**
     * @var BlogId
     */
    private $blogId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Contents
     */
    private $contents;

    /**
     * コンストラクタ
     *
     * @param BlogId $blogId
     * @param UserId $userId
     * @param Title $title
     * @param Contents $contents
     */
    public function __construct(
        BlogId $blogId,
        UserId $userId,
        Title $title,
        Contents $contents
    ) {
        $this->blogId = $blogId;
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return BlogId
     */
    public function blogId(): BlogId
    {
        return $this->blogId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        return $this->title;
    }

    /**
     * @return Contents
     */
    public function contents(): Contents
    {
        return $this->contents;
    }
}
