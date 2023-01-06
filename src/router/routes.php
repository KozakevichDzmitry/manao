<?php

use app\services\Router;

Router::add_page('login', 'login');
Router::add_page('signup', 'signup');
Router::add_page('index.php', 'home');

Router::add_action('auth/login', 'authenticate');
Router::add_action('auth/logout', 'logOut');
Router::add_action('auth/signup', 'register');

Router::check_url($_GET['query']);