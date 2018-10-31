<?php
function get_category_list(){
	global $db;
	$sql_query = "SELECT * FROM wp_terms";
	$result = $db->query($sql_query);
	while($row = $result->fetch_array()){
		$data[] = $row;
	}
	return $data;
}

function get_category_ID($cat){
	global $db;
	$res = $db->query("SELECT * FROM wp_terms WHERE slug ='{$cat}'");
	$row = $res->fetch_assoc();
	return $row['term_id'];
}

function get_the_category_by_ID($id){
	global $db;
	
	$res = $db->query("SELECT name FROM wp_terms WHERE term_id='".$id."'");
	$row = $res->fetch_array();	
	return $row['name'];
}

function get_cat_name($term_id){
	global $db;
	$res = $db->query("SELECT * FROM wp_terms WHERE term_id ='{$term_id}'");
	$row = $res->fetch_assoc();
	return ucwords($row['name']);
}

function get_cat_post($term_id,$limit=5){
	global $db;
	
	$sql_query = "SELECT * FROM wp_posts";
	if($term_id!==null) $sql_query .= " WHERE post_terms ='{$term_id}'";
	$sql_query .= " ORDER BY post_date DESC LIMIT $limit";
	
	$res = $db->query($sql_query);
	if($res->num_rows){
		while($row = $res->fetch_assoc()){
			$data[] = $row;
		}
		return $data;
	}
}