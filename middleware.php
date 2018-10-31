<?php

class MyMiddleware extends \Slim\Middleware{
	
    public function call(){
		global $db;
		
		$app = $this->app;
		$req = $app->request();
		
		$app->hook('slim.before.router', function () use ($app) {
			if(empty($_SESSION['user_login'])){
				//$app->redirect('login');
				//$app->render('login.php');
			}
			//$app->stop();
		});
		
		$app->hook('slim.before', function () use ($app, $db) {
			$base = "http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			//print_r ($base);
			$app->view()->appendData(array(
				'site_url' => rtrim($base, "/"),
				'base_url' => $base . '/' . $app->request()->getRootUri(),
				'template_url' => $base . '/templates',
				'current_url' => $app->request()->getResourceUri(),
				'db' => $db
			));
		});
		
		$app->hook('slim.before', function () use ($app) {
			$base_url = $app->request->getUrl();
			$base_url .= $app->request->getRootUri();
			
			$app->view()->appendData(array(
				'baseUrl' => $base_url,
				'title' => 'KLINIK PENDAMPINGAN HUKUM'
			));
		});

		$this->next->call();
    }
	
}