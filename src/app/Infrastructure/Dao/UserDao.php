<?php
/**
 * ユーザー情報を操作するDAO
 */
final class UserDao
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
     * ユーザーを追加する
     * @param  string $name
     * @param  string $email
     * @param  string $password
     */
    public function createUser(string $name, string $email, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = <<<EOF
            INSERT INTO
                users
                    (name
                    , email
                    , password)
            VALUES
                (:name
                , :email
                , :password)
            ;
        EOF;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * ユーザーを検索する
     * @param  string $email
     */
    public function findUserByMail(string $email)
    {
	$sql = <<<EOF
        SELECT * FROM
            users
        WHERE
            email = :email
        ;
    EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$member = $statement->fetch(PDO::FETCH_ASSOC);
	return $member;
    }

    /**
     * 一致するEメールあるかユーザー検索
     * @param string $email
     */
    public function login(string $email): ?array
    {
	$sql = <<<EOF
		SELECT * FROM
			users
		WHERE
			email = :email
		;
	EOF;
	$statement = $this->pdo->prepare($sql);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$member = $statement->fetch(PDO::FETCH_ASSOC);
	return $member ? $member : null;
    }
}
