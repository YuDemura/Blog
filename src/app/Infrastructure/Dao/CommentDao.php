<?php
/**
 * コメント情報を操作するDAO
 */
final class CommentDao
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=blog;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (PDOException $e) {
            exit('DB接続エラー:' . $e->getMessage());
        }
    }

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
    public function postComment(string $user_id, string $blog_id, string $commenter_name, string $comments): void
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
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindValue(':blog_id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':commenter_name', $commenter_name, PDO::PARAM_STR);
	$statement->bindValue(':comments', $comments, PDO::PARAM_STR);
	$statement->execute();
    }
}
