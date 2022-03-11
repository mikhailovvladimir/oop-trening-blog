<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class UsersAuthService
{
    const TABLE = 'users';

    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = self::checkToken();

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        return $user;
    }

    public static function checkToken(): ?string
    {
        $token = $_COOKIE['token'] ?? '';

        $reg = '/\d+:.+/m';
        $filterToken = preg_match_all($reg, $token, $matches, PREG_SET_ORDER, 0);

        if ($filterToken) {
            return $token;
        }

        return null;
    }
}