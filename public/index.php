<?php
// front controller

// require the controller class
//require '../App/controllers/Posts.php';

require_once dirname(__DIR__) . '/vendor/Twig/lib/Twig/Autoloader.php';
Twig_autoloader::register();


/*
autoloader class
*/
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
    	require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

/*
Error and Exception Handling
*/
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


//echo 'Requested url = "' . $_SERVER['QUERY_STRING'] . '"';

//require '../Core/Router.php';

$router = new Core\Router();

//echo get_class($router);

//add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts',['controller'=>'Posts', 'action'=> 'index']);
//$router->add('posts/new',['controller'=>'Posts','action'=>'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace'=>'Admin']);

//display the routing table
// echo '<pre>';
// //var_dump($router->getRoutes());
// echo htmlspecialchars(print_r($router->getRoutes(), true));
// echo '</pre>';

//match the requested route
// $url = $_SERVER['QUERY_STRING'];

// if ($router->match($url)) {
// 	echo '<pre>';
// 	var_dump($router->getParams());
// 	echo '</pre>';
// } else {
// 	echo "No route found for the url '$url'";
// }
$router->dispatch($_SERVER['QUERY_STRING']);