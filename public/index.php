<?php
require_once __DIR__ . '/../includes/autoload.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/saadan-virker-det', 'HomeController@saadan');
$router->get('/for-dig', 'HomeController@forDig');
$router->get('/frivillig', 'HomeController@frivillig');
$router->get('/kontakt', 'HomeController@kontakt');
$router->get('/kalender', 'HomeController@kalender');
$router->get('/login', 'HomeController@loginForm');
$router->post('/login', 'HomeController@login');

$router->get('/kalender-admin', 'HomeController@kalenderAdmin');
$router->get('/logout', 'HomeController@logout');
$router->protect('/kalender-admin');

$router->dispatch();
?>