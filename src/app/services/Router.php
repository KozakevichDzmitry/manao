<?php

namespace App\services;

use Exception;

require_once($_SERVER["DOCUMENT_ROOT"] . '/app/User.php');

class Router
{
    private static array $list_pages = [];
    private static array $list_actions = [];

    public static function add_page($url, $page): void
    {
        self::$list_pages[] = [
            'url' => $url,
            'page' => $page
        ];
    }

    public static function add_action($url, $method,): void
    {
        self::$list_actions[] = [
            'url' => $url,
            'method' => $method,

        ];
    }

    public static function check_url($url): void
    {
        //Pages
        foreach (self::$list_pages as $route) {
            if ($route['url'] === $url) {
                self::redirect($route['page']);
                die();
            }
        }

        //Check ajax referer
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            exit;
        }

        //Actions
        foreach (self::$list_actions as $action) {
            if ($action['url'] === $url) {
                try {
                    if ($action['url'] === 'auth/logout') {
                        User::logOut(['auth', 'login']);
                        header("Refresh:0; url=/login");
                        die();
                    }
                    $user = new User($_POST, $action['method']);
                    $response = $user->getErrors();
                    $response['isLogin'] = $user->isLogin();
                    $response['isRegistered'] = $user->isRegistered();
                    echo json_encode($response);

                } catch (Exception $e) {
                    self::redirect('404', $e->getMessage());
                }
                die();
            }
        }

        //if not found page or action
        self::redirect('404');
    }

    public static function redirect($page, $message = null): void
    {
        require_once('./pages/' . $page . '.php');
    }

}