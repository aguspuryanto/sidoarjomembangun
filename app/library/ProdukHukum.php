<?php
/*
	PRODUK HUKUM
*/

function tot_produkhukum(){
	global $db;
	$sql = $db->query("select count(*) from wp_produk_hukum");
	$data = $sql->num_rows;
	return $data;
}

function get_produk_cat(){
	global $db;
	$sql = $db->query("select * from wp_produk_cat");
	while($row = $sql->fetch_array()){
		$data[$row['cat_id']] = $row['name'];
	}
	return $data;
}

function get_produk_list($id=''){
	global $db;
	
	$page = 0;
    $offset = 0;
	$limit = 10;
	
	if(isset($_GET['page'])) {
        $page = $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	$sql_query	= "select * from wp_produk_hukum limit $offset, $limit";
	if($id)	$sql_query = "select * from wp_produk_hukum where jenis = '$id' limit $offset, $limit";
	//print_r ($sql_query);
	
	$data	= null;
	$sql = $db->query($sql_query);
	if($sql){
		while($row = $sql->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
}

function insert_produkhukum($data){
	global $db;
	
	/* Since PHP 5.5 mysql_real_escape_string has been deprecated and as of PHP7 it has been removed. */
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_produk_hukum (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$res = $db->query($sql_query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	if(!$res){
		return false;
	}
	
	$id = (int) $db->insert_id;
	return $id;
}

function get_reply_pendampingan($id=''){
	global $db;
	
	$page = 0;
    $offset = 0;
	$limit = 10;
	
	if(isset($_GET['page'])) {
        $page = $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	$sql_query	= "select * from wp_replypendampingan";
	if($id)	$sql_query .= " where jenis = '$id'";
	$sql_query .= " limit $offset, $limit";
	//print_r ($sql_query);
	
	$data	= null;
	$sql = $db->query($sql_query);
	if($sql){
		while($row = $sql->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
}

function tot_repe(){
	global $db;
	$sql = $db->query("select count(*) from wp_replypendampingan");
	$data = $sql->num_rows;
	return $data;
}