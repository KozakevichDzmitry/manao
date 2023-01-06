<?php

class DB
{
    private static string $path = 'dbUsers.json';

    /**
     *Get all Users
     * @return array
     */
    private static function getAll(): array
    {
        $json = file_get_contents(self::$path);
        $date = json_decode($json, true);
        if (isset($date)) {
            return $date;
        }
        return [];
    }

    /**
     * Get User.
     * @param $login
     * @param $pass
     * @return array|null
     */
    public static function get($params): ?array
    {
        if (empty($params['login'])) {
            return null;
        }
        $jsonArray = self::getAll();
        if (!empty($params['password'])) {
            foreach ($jsonArray as $user) {
                if (password_verify($params['password'], $user['password']) &&
                    $params['login'] === $user['login']) {
                    return $user;
                }
            }
        } elseif (!empty($params['cookieKey'])) {
            foreach ($jsonArray as $user) {
                if ($params['cookieKey'] === $user['cookieKey'] &&
                    $user['cookieTime'] > time() &&
                    $params['login'] === $user['login']) {
                    return $user;
                }
            }
        } else {
            return null;
        }


        return null;

    }

    /**
     * Add User
     * @param $params
     * @return bool|array
     */
    public static function add($params): false|array
    {
        if (!isset($params['login'], $params['password'])) {
            return false;
        }
        $user = self::get([
            'login' => $params['login'],
            'password' => $params['password']
        ]);
        if ($user) {
            return false;
        }
        $passHash = password_hash($params['password'], PASSWORD_DEFAULT);
        $params['password'] = $passHash;
        unset($params['confirmPassword']);
        $jsonArray = self::getAll();
        $jsonArray[] = $params;
        file_put_contents(self::$path, json_encode($jsonArray, JSON_FORCE_OBJECT));
        return $params;
    }

    /**
     * Add or update Cookie
     * @param $login
     * @param $password
     * @return array|false
     */
    public static function addCookie($login, $password): false|array
    {
        if (!isset($login, $password)) {
            return false;
        }
        $cookieKey = password_hash($login, PASSWORD_DEFAULT);
        $cookieTime = time() + 60 * 60 * 24 * 30;
        $jsonArray = self::getAll();
        foreach ($jsonArray as $key => $value) {
            if (password_verify($password, $value['password']) && $value['login'] === $login) {
                $jsonArray[$key]['cookieKey'] = $cookieKey;
                $jsonArray[$key]['cookieTime'] = $cookieTime;
                break;
            }
        }
        file_put_contents(self::$path, json_encode($jsonArray, JSON_FORCE_OBJECT));
        return ['login' => $login, 'cookieKey' => $cookieKey, 'cookieTime' => $cookieTime];
    }

    /**
     * Delete User.
     * @param $params
     * @return bool
     */
    public static function delete($params): bool
    {
        if (!isset($params['login'], $params['password'])) {
            return false;
        }
        $user = self::get([
            'login' => $params['login'],
            'password' => $params['password']
        ]);
        if (!$user) {
            return false;
        }
        $jsonArray = self::getAll();
        foreach ($jsonArray as $key => $value) {
            if ($value['password'] === $user['password'] && $value['login'] === $user['login']) {
                unset($jsonArray[$key]);
                break;
            }
        }
        file_put_contents(self::$path, json_encode($jsonArray, JSON_FORCE_OBJECT));
        return true;
    }

}