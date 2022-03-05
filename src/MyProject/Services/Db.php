<?php

namespace MyProject\Services;

class Db
{
    /** @var \PDO */
    private $pdo;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    // метод для исполнения запросов
    public function query(string $sql, $params = []): ?array
    {
        // получаем PDOstatment - готовим запрос
        $sth = $this->pdo->prepare($sql);
        // исполняем запрос и получаем результат
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll();
    }
}