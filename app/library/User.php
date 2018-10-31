<?php
/* USERS */
function all_users($limit=10){
	global $db;
	
	$page 	= 0;
    $offset = 0;
	
	if(isset($_GET['page'])) {
        $page 	= $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	$sql = $db->query("SELECT * FROM wp_users ORDER BY ID DESC LIMIT $offset, $limit");
	$data = array();
	while($row = $sql->fetch_array()){
		$data[] = $row;
	}
	return $data;
}

function all_author(){
	global $db;	
	$sql = $db->query("SELECT * FROM wp_users");
	while($row = $sql->fetch_array()){
		$data[] = $row;
	}
	return $data;
}

function get_user($id=""){
	global $db;	
	
	if(empty($id)) $id = $_SESSION['ID'];
	
	$sql = $db->query("SELECT * FROM wp_users WHERE ID='".$id."'");
	if($sql->num_rows > 0){
		$data = $sql->fetch_array();	
		return $data;
	}
	$db->free();
}

function insert_users($data){
	global $db;
	
	$sql = "INSERT INTO `wp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `display_name`, `user_registered`) VALUES ('".$data['user_login']."', '".$data['user_pass']."', '".$data['user_login']."', '".$data['user_email']."', '".$data['display_name']."', '".date('Y-m-d H:i:s')."')";
		
	$duplicate = user_exist_by('user_email', $data['user_email']);	
	if($duplicate==0){
		$result = $db->query($sql);
		if($result){
			$user_id = $db->insert_id;
			return $user_id;
		}
	}
}

function user_exist_by($key, $value){
	global $db;
	
	$sql_query = "SELECT * FROM wp_users WHERE ".$key." ='".$value."'";
	$result = $db->query($sql_query);
	return $result->num_rows;
}

function insert_user_meta($user_id, $meta_key, $meta_value){
	global $db;
	$sql = "INSERT IGNORE INTO `wp_usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES ('".$user_id."', '".$meta_key."', '".$meta_value."')";
	$result = $db->query($sql);	
    return $result;
	//echo '<br>---';
	//print_r ($sql);
}

function update_user_meta($user_id, $meta_key, $meta_value){
	global $db;
	//$havemeta = get_user_meta($user_id, $meta_key);
	//if($havemeta){
		if($meta_value){
			$sql = "UPDATE `wp_usermeta` SET `meta_key` = '".$meta_key."', `meta_value` = '".$meta_value."' WHERE `user_id` = '".$user_id."'";
			//echo '<br>--';
			//print_r ($sql);
			$result = $db->query($sql);
		}
	//}else{
		//$result = insert_user_meta($user_id, $meta_key, $meta_value);
	//}
	//return $result;
}

function get_user_meta($user_id, $meta_key=''){
	global $db;
	$sql = "SELECT meta_value FROM `wp_usermeta` WHERE `user_id` = '".$user_id."'";
	if($meta_key) $sql .= " AND meta_key='".$meta_key."'";
	//print_r ($sql);
	$result = $db->query($sql);
	$row = $result->fetch_array();	
    return $row['meta_value'];
}

function get_userdata($id){
	global $db;
	
	$res = $db->query("SELECT display_name FROM wp_users WHERE ID='".$id."'");
	$row = $res->fetch_array();	
	return $row['display_name'];
}

function get_user_role($id){
	global $db;
	
	/*$sql_query = "SELECT meta_value FROM wp_usermeta WHERE user_id='".$id."' AND meta_key='user_level'";
	//echo $sql_query."<br>";
	$res = $db->query($sql_query);
	$row = $res->fetch_array();*/
	
	$row = get_user_meta($id, 'user_level');
	return user_level($row);
}

function user_level($id){
	switch($id){
		case '4':
			return 'Administrator';
			break;
		case '3':
			return 'Editor';
			break;
		case '2':
			return 'Author';
			break;
		case '1':
			return 'Contributor';
			break;
		case '0':
			return 'Staff';
			break;
	}
}

function save_user(){
	$err = '';
	if(empty($_POST['user_login'])){
		$err .= 'Username Kosong';
	}
	if(empty($_POST['user_email'])){
		$err .= 'Email Kosong';
	}
	if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
		$err .= 'Invalid email format';
	}
	
	if($err){
		echo '<div class="alert alert-warning">'.$err.'</div>';
		return false;
	}
	
	if(!$err){
		$data = array(
			'user_login' => $_POST['user_login'],
			'user_email' => $_POST['user_email'],
			'display_name' => $_POST['display_name'],
			'user_status' => 1
		);
		
		if($_POST['user_pass']){
			$data = array_merge($data, array('user_pass' => md5($_POST['user_pass'])));
		}
		
		if($_POST['edit']==0){
			$insert_id = insert_users($data);
			if($insert_id){
				echo '<div class="alert alert-success">Data User Tersimpan.</div>';
				
				//insert_user_meta($insert_id, 'user_first', $_POST['user_first']);
				//insert_user_meta($insert_id, 'user_last', $_POST['user_last']);
				insert_user_meta($insert_id, 'user_level', $_POST['user_role']);
				
				if($_POST['user_role']<4){
					insert_user_meta($insert_id, 'nama_desa', $_POST['nama_desa']);
				}
			}else{
				echo '<div class="alert alert-warning">Data User Gagal Tersimpan.</div>';
			}
		}
		
		if($_POST['edit']==1){
			update_user($data, $_POST['ID']);
			update_user_meta($_POST['ID'], 'user_level', $_POST['user_role']);
			update_user_meta($_POST['ID'], 'kode_kec', $_POST['kec']);
			update_user_meta($_POST['ID'], 'kode_desa', $_POST['nama_desa']);
			echo '<div class="alert alert-success">Update Data Tersimpan.</div>';
		}
	}
}

function update_user($data,$id){
	global $db;
		
	foreach($data as $key=>$value){
		if(!empty($value)){
			$key = $db->real_escape_string($key);
			$value = $db->real_escape_string($value);
			$result[] = $key." = '".$value."'";
        }
    }
	
    $query = "UPDATE wp_users SET ".implode(', ',$result)." WHERE ID='".$id."'";
    //print_r ($query)."<br>";
	$res = $db->query($query);
	if($res){
		//update_user_meta($id, 'user_first', $_POST['user_first']);
		//update_user_meta($id, 'user_last', $_POST['user_last']);
		//update_user_meta($id, 'user_level', $_POST['user_role']);
		//update_user_meta($id, 'kode_kec', $_POST['kec']);
		//update_user_meta($id, 'kode_desa', $_POST['nama_desa']);
		//update_user_meta($id, 'nama_desa', $_POST['nama_desa']);
	}
	//return $res;
}