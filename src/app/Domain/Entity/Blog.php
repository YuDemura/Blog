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
    private $blogid;

    /**
     * @var UserId
     */
    private $userid;

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
     * @param BlogId $blogid
     * @param UserId $userid
     * @param Title $title
     * @param Contents $contents
     */
    public function __construct(
        BlogId $blogid,
        UserId $userid,
        Title $title,
        Contents $contents
    ) {
        $this->blogid = $blogid;
        $this->userid = $userid;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * @return BlogId
     */
    public function blogid(): BlogId
    {
        return $this->blogid;
    }

    /**
     * @return UserId
     */
    public function userid(): UserId
    {
        return $this->userid;
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
