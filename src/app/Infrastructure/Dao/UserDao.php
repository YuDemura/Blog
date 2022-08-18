<?php
namespace App\Infrastructure\Dao;

require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\NewUser;
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
    public function create(NewUser $user): void
    {
        $hashedPassword = $user->password()->hash();

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
        $statement->bindValue(':name', $user->name()->value(), PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email()->value(), PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword->value(), PDO::PARAM_STR);
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
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user === false ? null : $user;
    }
}
