<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';

use PDO;
/**
 * ユーザー情報を操作するDAO
 */
final class UserDao extends Dao
{
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
}
