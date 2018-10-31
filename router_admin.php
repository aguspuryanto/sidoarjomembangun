<?php

$app->group('/wp-admin', function () use ($app) {
	
	// Login
    $app->get('/login', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->render('login.php');
		}else{
			$app->redirect('dashboard');
		}
	});
	
	// Login POST
	$app->post('/login', function() use ($app) {
		
		$inputEmail 	= $app->request()->post('inputEmail');
		$inputPassword 	= md5($app->request()->post('inputPassword'));
		
		if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL) === false) {
			
			$sql_query = "SELECT * FROM wp_users WHERE (user_email='".$inputEmail."' OR user_login='".$inputEmail."') AND user_pass='".$inputPassword."'";
			// echo $sql_query; die();
			$result = $app->db->query($sql_query);
			if (!$result){
				$app->flash('error', $app->db->error);
				$flash = $app->view()->getData('flash');
				$app->render('login.php');
				return;
			}
			
			if($result->num_rows > 0){
				while($row = $result->fetch_array()) {
					$data = $row;
				}
				
				// var_dump ($data); die();
				$_SESSION['display_name']	= $data['display_name'];
				$_SESSION['user_login']	= $data['user_login'];
				$_SESSION['ID']	= $data['ID'];
				
				$app->redirect('./dashboard');
				return;
				
			}else{
				$app->flash('error', 'Silahkan cek kembali Usernama ATAU Password Anda!');
				$flash = $app->view()->getData('flash');
				$app->render('login.php');
			}
		}else{
			// Set flash message for next request
			$app->flash('error', $inputEmail.' is not a valid email address');
			$flash = $app->view()->getData('flash');
			
			$app->render('login.php');
		}
	});
	
	// Pendampingan
    $app->map('/pendampingan-list', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/pendampingan.php');
		}
	})->via('GET', 'POST');
	
	// Tambah Pendampingan
    $app->map('/pendampingan-reply', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/pendampingan_reply.php');
		}
	})->via('GET', 'POST');
	
	// Tambah Pendampingan
    $app->map('/pendampingan-add', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/pendampingan_add.php');
		}
	})->via('GET', 'POST');
	
	// Tigkat Pendidikan
    $app->map('/edu(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/edu.php', array('tipe' => $tipe,'id' => $id));
		}
	})->via('GET', 'POST');
	
	// Pejabat
    $app->map('/pejabat(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/pejabat.php', array('tipe' => $tipe,'id' => $id));
		}
	})->via('GET', 'POST');
	
	// Category Produk Hukum
    $app->get('/produkhukum/category', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/produkhukum_category.php');
		}
	});
	
	// Produk Hukum	
    $app->map('/produkhukum(/:all)', function($all="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/produkhukum.php', array("category" => $all));
		}
	})->via('GET', 'POST');
	
	// Tambah Category Produk Hukum
    $app->post('/produkhukum/category/add', function() use ($app) {
		$post = $app->request->post();
		//var_dump ($data);
		
		$sql = "insert into wp_produk_cat (`name`)VALUES ('".$post['cat']."')";
		$result	= $app->db->query($sql);
		if($result) echo '<div class="alert alert-warning">Category Telah Tersimpan</div>';
	});
	
	// Dana Desa
    $app->map('/dana(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/dana.php', array('tipe' => $tipe,'id' => $id));
		}
	})->via('GET', 'POST');	
	
	// Tambah Sumber Dana desa
    $app->post('/tambahdana', function() use ($app) {
		$data = $app->request->post();
		//print_r($data);
		$sql = "insert into wp_danadesa_cat (`name`) VALUES ('".$post['sumberdana']."')";
		$result	= $app->db->query($sql);
		if($result) echo '<div class="alert alert-warning">Sumber Dana Desa Telah Tersimpan</div>';
	});
	
	// Realisasi
    $app->map('/realisasi(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/realisasi.php', array('tipe' => $tipe,'id' => $id));
		}
	})->via('GET', 'POST');
	
	// Report Dana Desa
    $app->get('/report(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/report.php', array('tipe' => $tipe,'id' => $id));
		}
	});
	
	// Dashboard
    $app->get('/dashboard', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/dashboard.php');
		}
	});
	
	// Posts New
    $app->map('/post-new', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/post-new.php');
		}
	})->via('GET', 'POST');
	
	// Posts Category
    $app->map('/post-category', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/post-category.php');
		}
	})->via('GET', 'POST');
	
	// Posts
    $app->map('/edit', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/allposts.php');
		}
	})->via('GET', 'POST');
	
	// Delete Gallery
    $app->post('/gallery/delete', function() use ($app) {
		$data = $app->request->post();
		//print_r ($data['filename']);
		
		$filename = explode("/", $data['filename']);
		$filename = end($filename);		
		
		$sql = "delete from wp_album_files where files_name='".$filename."'";
		//print_r ($sql);
		if($filename) $res = $app->db->query($sql);
		
		if(file_exists($data['filename'])){
			unlink($data['filename']);
		}
	});
	
	// Create Album
    $app->post('/gallery/album', function() use ($app) {
		
		$data = $app->request->post();
		//var_dump ($data);
		
		$newdata = array(
			'kode_desa' => $data['kode_desa'],
			'nama_album' => $data['gallery_album'],
			'desc_album' => $data['gallery_desc']
		);
		
		$double = double_album($newdata);
		if($double==0){
			$result = save_album($newdata);
			echo $result;
		}else{
			echo json_encode(array('result' => 'failed', 'message' => 'Duplicate Album'));
		}
	});
	
	// New Album Gallery; method: GET
    $app->get('/newalbum(/:id)', function($id='') use ($app) {
		$data = $app->request->post();
		
		$app->render('wp-admin/gallery_album.php', array('album_id' => $id));
	});
	
	// Upload Gallery
    $app->post('/newalbum/upload', function() use ($app) {
		$data = $app->request->post();
		
		$arg = array(
			'files_name' => $_FILES['gallery_files']['name'],
			'files_album' => $data['album_id']
		);
		
		simpan_album_files($arg);
		
		$app->render('wp-admin/gallery_upload.php');
	});
	
	// Tambah Gallery
    $app->map('/gallery(/:id)', function($id='') use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$t=time();
			$unique = md5($t);	
			$app->etag($unique);
			
			$app->render('wp-admin/gallery.php', array('album_id' => $id));
		}
	})->via('GET', 'POST'); 
	
	// Hapus Album
    $app->get('/gallery/delete(/:id)', function($id) use ($app) {
		$sql = "delete from wp_album where album_id='".$id."'";
		$res = $app->db->query($sql);
	});
	
	// All Users
    $app->get('/allusers', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/allusers.php');
		}
	});
	
	// Users
    $app->map('/usernew', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}else{
			$app->render('wp-admin/usernew.php');
		}
	})->via('GET', 'POST');
	
	$app->map('/desa', function() use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}
		$app->render('wp-admin/desa.php');
	})->via('GET', 'POST');
	
	$app->get('/list-desa(/:tipe(/:id))', function($tipe="", $id="") use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}
		$app->render('wp-admin/desa_list.php', array(
			'tipe' => $tipe,
			'id' => $id
		));
	});
	
	$app->get('/getdatakab(/:id)', function($id) use ($app) {
		//echo $id;
		$sql_query = $app->db->query("SELECT * FROM wp_bukuinduk WHERE parent='".$id."'");
		
		echo '<option value="#">PILIH KABUPATEN/KOTA</option>';
		while($row = $sql_query->fetch_array()){
			if($row['kode']=='35.15') echo '<option data-id="'.$row['kode'].'" value="'.$row['nama'].'">'.$row['nama'].'</option>';
		}
	});
	
	$app->get('/getdatakec(/:id)', function($id) use ($app) {
		//echo $id;
		$sql_query = $app->db->query("SELECT * FROM wp_bukuinduk WHERE parent='".$id."'");
		
		echo '<option value="#">PILIH KECAMATAN</option>';
		while($row = $sql_query->fetch_array()){
			echo '<option data-id="'.$row['kode'].'" value="'.$row['nama'].'">'.$row['nama'].'</option>';
		}
	});
	
	$app->get('/getdatadesa(/:id)', function($id) use ($app) {
		//echo $id;
		$sql_query = $app->db->query("SELECT * FROM wp_bukuinduk WHERE parent='".$id."'");
		
		echo '<option value="#">PILIH DESA</option>';
		while($row = $sql_query->fetch_array()){
			echo '<option value="'.$row['kode'].'">'.$row['nama'].'</option>';
		}
	});
	
	$app->post('/tableedit', function() use ($app) {
		$data = $app->request->getBody();
		$data = $app->request->post();
		//print_r($data);
		$sql_query = "INSERT INTO wp_bukuinduk_data (`idbukuinduk`,`luas_wilayah`,`jml_penduduk`) VALUES ('".$data['id']."','".$data['luas_wilayah']."','".$data['jml_penduduk']."') ON DUPLICATE KEY UPDATE luas_wilayah = '".$data['luas_wilayah']."'";
		if($data['jml_penduduk']) $sql_query .= ", jml_penduduk = '".$data['jml_penduduk']."'";
		//print_r($sql_query);
		$app->db->query($sql_query);
	});
	
	$app->get('/list-desa(/:id)', function($id) use ($app) {
		if(empty($_SESSION['user_login'])){
			$app->redirect('login');
		}
		$app->render('wp-admin/desa_list.php',array('id' => $id));
	})->conditions(array('id' => '[0-9.]{2,}'));
	
	
	// Delete Posts
    $app->delete('/post-delete(/:id)', function($id) use ($app) {
		$app->db->query("DELETE FROM wp_posts WHERE ID='".$id."'");
	});
	
	// Delete Users
    $app->delete('/allusers(/:id)', function($id) use ($app) {
		$app->db->query("DELETE FROM wp_users WHERE ID='".$id."'");
	});
	
	// Delete Pendampingan
    $app->delete('/pendampingan(/:id)', function($id) use ($app) {
		$app->db->query("DELETE FROM wp_comments WHERE comment_ID='".$id."'");
	});
	
	// Delete Reply Pendampingan
    $app->delete('/reply(/:id)', function($id) use ($app) {
		$app->db->query("DELETE FROM wp_replypendampingan WHERE reply_id='".$id."'");
	});
	
	// Delete pejabat
    $app->delete('/pejabat(/:id)', function($id) use ($app) {
		$app->db->query("DELETE FROM wp_pejabat WHERE pejabat_id='".$id."'");
	});
});

// Log Out
$app->get('/logout', function() use ($app) {
	session_destroy();
	$_SESSION = null;
	// Redirect
	$app->redirect('./');
});