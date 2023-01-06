<?php
namespace App\view;

class Page
{
    public static function header()
    {
        require_once('./pages/components/header.php');
    }
    public static function footer()
    {
        require_once('./pages/components/footer.php');
    }
    public static function header_menu()
    {
        require_once('./pages/components/header_menu.php');
    }
    public static function form_login()
    {
        require_once('./pages/components/form_login.php');
    }
    public static function form_signup()
    {
        require_once('./pages/components/form_signup.php');
    }

}