<?php
namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use PDO;
use App\Domain\ValueObject\NewBlog;
use App\Domain\ValueObject\UpdateBlog;
use App\Domain\ValueObject\Delete;

/**
 * Blog情報を操作するDAO
 */
final class BlogDao extends Dao
{
    /**
     * ブログ新規作成
     */
    public function create(NewBlog $blog): void
    {
	$sql = <<<EOF
		INSERT INTO
			blogs
				(user_id
				, title
				, contents)
		VALUES
			(:user_id
			, :title
			, :contents)
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':user_id', $blog->user_id()->value(), PDO::PARAM_INT);
	$statement->bindValue(':title', $blog->title()->value(), PDO::PARAM_STR);
    $statement->bindValue(':contents', $blog->contents()->value(), PDO::PARAM_STR);
	$statement->execute();
    }

    /**
     * 記事削除
     */
    public function delete(Delete $blog): void
    {
	$sql = <<<EOF
		DELETE FROM
			blogs
		WHERE
			id =:id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindParam(':id', $blog->blog_id()->value(), PDO::PARAM_INT);
	$statement->execute();
    }

    /**
     * 記事編集
     * @param string $blog_id
     * @param string $user_id
     */
    public function edit(string $blog_id, string $user_id): ?array
    {
	$sql = <<<EOF
		SELECT
			id
			, title
			, contents
			, created_at
		FROM
			blogs
		WHERE
			id=:id
			and
			user_id = :user_id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch();
	return $blog;
    }

    /**
     * Topページでブログを一覧表示させる
     * @param string $user_id
     * @param string $title
     * @param string $contents
     * @param string $direction
     */
    public function showList(string $user_id, string $title, string $contents, string $direction): ?array
    {
	$sql = <<<EOF
		SELECT
			title
			, created_at
			, contents
			, id
		FROM
			blogs
		WHERE
			user_id=:user_id
			and
			(title LIKE :title
			OR
			contents LIKE :contents)
		ORDER BY
			id $direction
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindValue(':title', $title, PDO::PARAM_STR);
	$statement->bindValue(':contents', $contents, PDO::PARAM_STR);
	$statement->execute();
	$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $blogs;
    }

    /**
     *記事詳細（マイページから遷移）
     * @param string $user_id
     * @param string $blog_id
     */
    public function showDetail(string $user_id, string $blog_id)
    {
	$sql = <<<EOF
		SELECT
			id
			,user_id
			, title
			, contents
		FROM
			blogs
		WHERE
			id=:id
			and
			user_id=:user_id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
    }

    /**
     * 記事詳細(Topページから遷移）
     * @param string $blog_id
     */
    public function showDetailForComment(string $blog_id)
    {
	$sql = <<<EOF
		SELECT
			id
			, title
			, contents
			, created_at
		FROM
			blogs
		WHERE
			id=:id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
    }

    /**
     * マイページ表示
     * @param string $user_id
     */
    public function showMypage(string $user_id): ?array
    {
	$sql = <<<EOF
		SELECT
			id
			, title
			, contents
			, created_at
		FROM
			blogs
		WHERE
			user_id=:user_id
			and
			length(contents) <= 15
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $blogs;
    }

    /**
     * 記事編集処理
     */
    public function update(UpdateBlog $blog): void
    {
	$sql = <<<EOF
		UPDATE
			blogs
		SET
			title=:title
			, contents=:contents
		WHERE
			id = :id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':title', $blog->title()->value(), PDO::PARAM_STR);
	$statement->bindValue(':contents', $blog->contents()->value(), PDO::PARAM_STR);
	$statement->bindParam(':id', $blog->blog_id()->value(), PDO::PARAM_INT);
	$statement->execute();
    }

	 /**
     * ブログを検索する
	 * ブログID=XXの記事をDBから取得し、その記事を書いた人のユーザIDを取得

     * @param  string $blog_id
     */
    public function findById(string $blog_id)
    {
	$sql = <<<EOF
		SELECT
			id
			, user_id
			, title
			, contents
		FROM
			blogs
		WHERE
			id = :id
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':id', $blog_id, PDO::PARAM_INT);
	$statement->execute();
	$blog = $statement->fetch(PDO::FETCH_ASSOC);
	return $blog;
    }
}
