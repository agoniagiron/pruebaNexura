<?php
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    private PDO $pdo;

    public function __construct(array $cfg)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $cfg['host'],
            $cfg['port'],
            $cfg['dbname'],
            $cfg['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], $options);
        } catch (PDOException $e) {
            throw new PDOException('DB Connection failed: ' . $e->getMessage(), (int)$e->getCode());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
