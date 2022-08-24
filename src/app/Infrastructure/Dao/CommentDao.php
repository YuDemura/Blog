<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewComment;
use PDO;
/**
 * コメント情報を操作するDAO
 */
final class CommentDao extends Dao
{
    /**
     * コメントする記事表示
     * @param string $blog_id
     * @param string $user_id
     */
    public function commentToPost(string $blog_id, string $user_id): ?array
    {
	$sql = <<<EOF
		SELECT
			commenter_name
			, comments
			, created_at
		FROM
			comments
		WHERE
			blog_id=$blog_id
			and
			user_id=$user_id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->execute();
	$comments_post = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $comments_post;
    }

    /**
     * コメント投稿機能
     * @param string $user_id
     * @param string $blog_id
     * @param string $commenter_name
     * @param string $comments
     */
    public function postComment(NewComment $comment): void
    {
	$sql = <<<EOF
		INSERT INTO
			comments
				(user_id
				, blog_id
				, commenter_name
				, comments)
		VALUES
			(:user_id
			, :blog_id
			, :commenter_name
			, :comments)
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':user_id', $comment->user_id()->value(), PDO::PARAM_INT);
	$statement->bindValue(':blog_id', $comment->blog_id()->value(), PDO::PARAM_INT);
	$statement->bindValue(':commenter_name', $comment->commenterName()->value(), PDO::PARAM_STR);
	$statement->bindValue(':comments', $comment->comments()->value(), PDO::PARAM_STR);
	$statement->execute();
    }
}
