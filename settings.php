<?php
/* define a working directory
 * dirname(__FILE__) => D:\AppServ\www\hotelokal PHP < 5.3 PHP < 5.3
 * __DIR__ only exists with PHP >= 5.3
 */
 
define('APP_PATH', __DIR__);

//deklarasi koneksi database melalui library NotORM
$username = "root"; //"sdjmbcom";
$password = "103Wonokromo"; //"46P43kdY";
$db = new mysqli("localhost",$username,$password,"sisfodesa");
if($db === false) {
define('DIR_HLP', APP_PATH.'/app/helper');
foreach (glob(DIR_HLP .'/*.php') as $file_name){
    require $file_name;
}
define('DIR_LIB', APP_PATH.'/app/library');
foreach (glob(DIR_LIB .'/*.php') as $file_name){
    require $file_name;
}
$app = new \Slim\Slim(array(
	'debug' => true,
	'templates.path' => './templates'
$app->container->singleton('db', function() use ($db) {
$app->container->singleton('category', function() use ($db) {