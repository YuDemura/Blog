<?php
namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use PDO;

abstract class Dao
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:dbname=blog;host=mysql;charset=utf8',
            'root',
            'password'
        );
    }
}
