<?php

namespace MyProject\Models\Users;

use http\Encoding\Stream\Inflate;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public static function signUp(array $userData)
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = self::findOneByColumn('email', $loginData['email']);
        if (!isset($user)) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Не правильно указан пароль!');
        }
        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    // обновляем токен при авторизации
    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public function isAdmin(): bool
    {
        define('ADMIN', 'admin');
        return $this->getRole() === ADMIN;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}