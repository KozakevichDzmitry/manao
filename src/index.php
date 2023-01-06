<?php
session_start();
require_once __DIR__ . "/app/db/DB.php";
if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {
    if ( !empty($_COOKIE['login']) and !empty($_COOKIE['key']) ) {
        $login = htmlspecialchars($_COOKIE['login']);
        $key = htmlspecialchars($_COOKIE['key']);
        $result = DB::get(['login'=>$login, 'cookieKey'=>$key, ]);
        if (!empty($result)) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $login;
        }
    }
}

$user= [
    'login' => 'Kozakevich',
    'name'  => 'Dima',
    'email' => 'exampl@mail.com',
    'password' => 'qq12345678'
];
$user1= [
    'login' => 'Kuchuk',
    'name'  => 'Marina',
    'email' => '2@mail.com',
    'password' => 'qwerty123'
];
$user2= [
    'login' => 'Kuchuk2',
    'name'  => 'Marina2',
    'email' => '222@mail.com',
    'password' => '222qwerty'
];
//DB::add($user);
//DB::add($user1);
//DB::add($user2);
//var_dump(DB::delete($user2));

require_once __DIR__ . "/app/services/Router.php";
require_once __DIR__ . "/router/routes.php";