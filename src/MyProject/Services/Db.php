<?php

namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Db
{
    /** @var \PDO */
    private $pdo;

    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];
        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подлючени к базе данных');
        }
    }

    // метод для исполнения запросов
    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        // получаем PDOStatment - готовим запрос
        $sth = $this->pdo->prepare($sql);
        // исполняем запрос и получаем результат
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }
        // если третий аргумент указан, то возвращает объект указанного класса
        // и заполнненными свойствами из бд
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}