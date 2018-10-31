<?php
/*
 * CMS FOR MEDIAVIBRI.COM
 * Require : Slim Framework 2
 * Developer : Agus Puryanto
 * Email : aguspuryanto@gmail.com
 */
 
date_default_timezone_set('Asia/Jakarta');
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', 0);
 
// Start PHP session
session_start();
ob_start();

/* Require Slim and plugins */
require 'Slim/Slim.php';

/* Register autoloader and instantiate Slim */
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/* Database Configuration */
require ('settings.php');
require ('function.php');
require ('middleware.php');

$app->add(new \MyMiddleware());

/* Routes */
$app->get('/', function () use ($app,$db) {	
	$app->render('main.php', array(
		'db' => $db
	));
});

include ('router_admin.php');
include ('router_category.php');
include ('router_demo.php');
include ('router_posts.php');

//$content = ob_get_contents();
//ob_end_clean();

/* Run the application */
$app->run();