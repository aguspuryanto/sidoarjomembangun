<?php

function get_comments($id=""){
	global $db;
	
	$sql_query = "SELECT * FROM wp_comments WHERE comment_approved='1'";
	if($id) $sql_query .= " AND user_id='".$id."'";
	$sql_query .= " ORDER BY comment_date DESC";
	//print_r ($sql_query);
	
	$res = $db->query($sql_query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	if($res->num_rows > 0){
			while($row = $res->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
}

function insert_comment($data){
	global $db;
	
	$data = array_merge($data, array('comment_date_gmt' => date('Y-m-d H:i:s')));
	
	/* Since PHP 5.5 mysql_real_escape_string has been deprecated and as of PHP7 it has been removed. */
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_comments (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$res = $db->query($sql_query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	if(!$res){
		return false;
	}
	
	$id = (int) $db->insert_id;
	return $id;
}

function update_comment($data, $id){
	global $db;
	
	foreach($data as $key=>$value){
		if(!empty($value)){
			$key = $db->real_escape_string($key);
			$value = $db->real_escape_string($value);
			$result[] = $key." = '".$value."'";
        }
    }
    $query = "UPDATE wp_comments SET ".implode(', ',$result)." WHERE comment_ID = '".$id."'";
    $res = $db->query($query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	return $res;
}

function get_comments_ID($id){
	global $db;
	
	$sql_query = "SELECT * FROM wp_comments WHERE comment_ID = '".$id."'";
	$res = $db->query($sql_query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	$row = $res->fetch_array();
	
	return $row;
}

//Reply Pendampingan
function save_reply($data){
	global $db;
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_replypendampingan (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;	
}



function get_reply($id=''){
	global $db;
	
	$sql_query	= "select * from wp_replypendampingan where comment_ID = '$id'";
	$sql = $db->query($sql_query);
	
	$data = array();
	while($row = $sql->fetch_array()){
		$data = $row;
	}
	
	if($data){
		return array(
			'total' => $sql->num_rows,
			'data' => $data
		);
	}
}

function get_allreply($id=''){
	global $db;
	
	$page = 0;
    $offset = 0;
	$limit = 10;
	
	if(isset($_GET['page'])) {
        $page = $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	$sql_query	= "select * from wp_replypendampingan";
	if($id)	$sql_query .= " where comment_ID = '$id'";
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

function tot_reply(){
	global $db;
	$sql = $db->query("select count(*) from wp_replypendampingan");
	$data = $sql->num_rows;
	return $data;
}