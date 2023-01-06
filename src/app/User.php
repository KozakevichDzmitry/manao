<?php

namespace App\services;

use DB;
use stdClass;

class User
{
    const messageError = [
        'authenticate' => 'User not found!',
        'register' => 'User with this name has already been registered.',
        'validateLogin' => 'Login is invalid. It should more 6 letters.',
        'validateEmail' => 'E-mail is invalid.',
        'validatePassword' => 'Password is invalid. It should more 6 characters and consist of numbers and letters.',
        'validateConfirmPassword' => '"Confirm password" and password should match.',
        'validateName' => 'Name is invalid.It should more 2 letters and consist only letters.',
    ];
    private string $login;
    private string $name;
    private string $email;
    private bool $isLogin = false;
    private bool $isRegistered = false;
    private array $errors = [];

    public function __construct($data, $action)
    {
        $data = $this->prepareDate($data);
        $errors = $this->validate($data);
        if (!$errors) {
            $this->$action($data); // authenticate or register
        } else {
            $this->errors['validate'] = $errors;
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function authenticate($data): void
    {
        $user = DB::get($data);
        if ($user) {
            $this->isLogin = true;
            $this->setParams($user);
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $data['login'];
            if(isset( $data['password'])){ // if authenticate by password, update cookie.
                $cookie = DB::addCookie($data['login'], $data['password']);
                $this->setcookie($cookie);
            }
        }
        $this->errors['authError'] = self::messageError['authenticate'];;
    }

    /**
     * @param $cookie
     * @return void
     */
    private function setcookie($cookie): void
    {
        if(!empty($cookie['cookieKey']) && !empty($cookie['cookieTime'])){
            setcookie('login', $cookie['login'], $cookie['cookieTime'], "/");
            setcookie('key',$cookie['cookieKey'], $cookie['cookieTime'], "/");
        }
    }


    /**
     * @param $data
     * @return void
     */
    private function register($data): void
    {
        $user = DB::add($data);
        if ($user) {
            $this->isRegistered =true;
            $this->setParams($user);
        }else{
            $this->errors['authError'] = self::messageError['register'];
        }

    }

    /**
     * @param $params
     * @return void
     */
    public static function logOut ($params): void
    {
        foreach ($params as $param){
            $_SESSION[$param] = null;
        }
        setcookie('login', '', time(), '/');
        setcookie('key', '', time(), '/');
    }

    /**
     * @param $data
     * @return array
     */
    private function validate($data): array
    {
        $errors = [];
        foreach ($data as $key => $value) {
            $value = trim($value);
            switch ($key) {
                case 'login':
                    if (strlen($value) < 6) {
                        $errors['login'] = self::messageError['validateLogin'];
                    }
                    break;
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = self::messageError['validateEmail'];
                    }
                    break;
                case 'password':
                    if (!preg_match("/^(?=.*[a-zA-ZА-Яа-яЁё])(?=.*[0-9]).{6,}/", $value)) {
                        $errors['password'] = self::messageError['validatePassword'];
                    }
                    break;
                case 'confirmPassword':
                    if ($value !== $data['password']) {
                        $errors['confirmPassword'] = self::messageError['validateConfirmPassword'];
                    }
                    break;
                case 'name':
                    if (!preg_match("/^(?=.*[a-zA-ZА-Яа-яЁё]).{2,}/", $value)) {
                        $errors['name'] = self::messageError['validateName'];
                    }
                    break;
            }
        }
        return $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        return $this->isLogin;
    }

    /**
     * @return bool
     */
    public function isRegistered(): bool
    {
        return $this->isRegistered;
    }

    /**
     * Sets the passed values to class parameters
     * @param $data
     */
    private function setParams($data): void
    {
        $this->login = $data['login'];
        $this->name = $data['name'];
        $this->email = $data['email'];
    }

    /**
     * Convert special characters to HTML entities
     */
    private function prepareDate($data): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }
}