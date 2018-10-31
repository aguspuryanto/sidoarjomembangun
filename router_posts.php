<?php
// DATA DESA
$app->get('/data-desa(/:id)', function ($id=null) use ($app) {
	$app->render('data_desa.php');
});

$app->get('/detail(/:id)', function ($id) use ($app) {
	//echo $id;	
	$res = $app->db->query("SELECT kode, nama FROM wp_bukuinduk WHERE id='".$id."'");
	$det = $res->fetch_assoc();
	
	$app->view()->setData(array(
		'title' => $det['nama'].' | SIDOARJO MEMBANGUN' 
    ));
	
	/******************************/
	$result = $app->db->query("SELECT * FROM wp_bukuinduk a LEFT JOIN wp_bukuinduk_data b ON b.idbukuinduk=a.id WHERE a.parent = '".$det['kode']."'");
	while($row = $result->fetch_assoc()){
		$data[] = $row;
	}
	
	$app->render('detail_desa.php', array(
		'kec'=> $det['nama'],
		'datakec'=> $data
	));
});

$app->get('/gallery(/:id)', function ($id='') use ($app) {
	$t=time();
	$unique = md5($t);	
	$app->etag($unique);
	
	$app->view()->setData(array(
		'title' => 'GALLERY - SIDOARJO MEMBANGUN' 
    ));
	
	$app->render('gallery.php', array('album_id' => $id));
});

$app->get('/berita(/:slug)', function ($slug=null) use ($app) {
	
	if($slug){
		$result = $app->db->query("SELECT * FROM wp_posts WHERE post_name='$slug'");
		while($row = $result->fetch_assoc()){
			$data = $row;
		}
		
		//print_r ($data);
		if($data){
			$app->view()->setData(array(
				'title' => $data['post_title'].' - SIDOARJO MEMBANGUN' 
			));
			
			$app->render('single.php', array(
				'post'=> $data
			));
		}
	}else{
		$app->view()->setData(array(
			'title' => 'BERITA - SIDOARJO MEMBANGUN' 
		));
		
		$result = $app->db->query("SELECT * FROM wp_posts");
		while($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		
		$app->render('page.php', array(
			'posts'=> $data
		));
	}
});

$app->map('/pendampingan', function () use ($app) {
	
	$app->view()->setData(array(
		'title' => 'PENDAMPINGAN - SIDOARJO MEMBANGUN' 
    ));
	
	$app->render('pendampingan.php');
})->via('GET', 'POST');

// Produk Hukum
$app->get('/produk-hukum(/:id)', function($id='') use ($app) {
	
	$result = $app->db->query("SELECT * FROM wp_produk_cat WHERE cat_id='$id'");
	$row	= $result->fetch_array();
	if($row){
		$title = ucwords($row['name'])."!";
	}else{
		$title = "Produk Hukum!";
	}
	
	$app->view()->setData(array(
		'title' => 'PRODUK HUKUM - SIDOARJO MEMBANGUN' 
    ));
	
	$app->render('produk-hukum.php', array(
		'id' => $id,
		'title' => $title
	));
});

$app->get('/download/produk-hukum(/:id)', function($id='') use ($app) {
	
	$result = $app->db->query("SELECT * FROM wp_produk_hukum WHERE produk_id='$id'");
	$row	= $result->fetch_array();
	
	$local_file	= dirname(__FILE__) . '/templates/wp-admin/uploads/'.$row['filename'];
	//print_r ($local_file);
	
	// set the download rate limit (=> 20,5 kb/s)
	$download_rate = 20.5;
	if(file_exists($local_file) && is_file($local_file))
	{
		header('Cache-control: private');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($local_file));
		header('Content-Disposition: filename='.$row['filename']);

		flush();
		$file = fopen($local_file, "r");
		while(!feof($file))
		{
			// send the current file part to the browser
			print fread($file, round($download_rate * 1024));
			// flush the content to the browser
			flush();
			// sleep one second
			sleep(1);
		}
		fclose($file);
	}
	else {
		die('Error: The file "<b>'.$local_file.'</b>" does not exist!');
	}
});

$app->get('/:slug', function ($slug) use ($app) {	
	
	if($slug!="wp-admin"){
		$result = $app->db->query("SELECT * FROM wp_posts WHERE post_name='$slug'");
		while($row = $result->fetch_assoc()){
			$data = $row;
		}
		
		//print_r ($data);
		if(!$data){
			$app->view()->setData(array(
				'title' => $data['post_title'].' - SIDOARJO MEMBANGUN' 
			));
			
			$app->render('single.php', array(
				'post'=> $data
			));
		}
	}else{
		$app->redirect('wp-admin/login');
	}
});