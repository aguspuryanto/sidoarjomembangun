<?php
function all_posts($limit=10){
	global $db;
	
	$page 	= 0;
    $offset = 0;
	
	if(isset($_GET['page'])) {
        $page 	= $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	if(get_user_meta($_SESSION['ID'], 'user_level')==4){
		$sql = $db->query("SELECT * FROM wp_posts ORDER BY post_date DESC LIMIT $offset, $limit");
	}else{
		$sql = $db->query("SELECT * FROM wp_posts where post_author='".$_SESSION['ID']."' ORDER BY post_date DESC LIMIT $offset, $limit");
	}	
	
	if($sql->num_rows){
		while($row = $sql->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
}

function get_posts($args=""){
	global $db;
	
	$page = 0;
    $offset = 0;
	$limit = 10;
	
	if(isset($_GET['page'])) {
        $page = $_GET['page'] + 1;
        $offset = $limit * $page ;
    }
	
	$sql_query 	= "SELECT * FROM wp_posts";
	if($args){
		$sql_query 	.= " WHERE post_title LIKE '%".$args['q']."%' OR post_content LIKE '%".$args['q']."%'";
	}
	$sql_query 	.= " ORDER BY ID DESC LIMIT $offset, $limit";
	//print_r ($sql_query);
	
	$result 	= $db->query($sql_query);
	while ($row = $result->fetch_assoc()) {
		$results[] = $row;
	}	
	return $results;
}

function num_all(){
	global $db;
	
	if(get_user_meta($_SESSION['ID'], 'user_level')==4){
		$result = $db->query("SELECT * FROM wp_posts");
	}else{
		$result = $db->query("SELECT * FROM wp_posts where post_author='".$_SESSION['ID']."'");
	}
	
	return $result->num_rows;	
	$result->close();
	$db->close();
}

function get_post($id){
	global $db;
	$sql_query = "SELECT * FROM wp_posts WHERE ID ='{$id}'";
	//echo $sql_query;	
	if ($result = $db->query($sql_query)) {
		$row = $result->fetch_assoc();
	}	
	return $row;	
	$result->close();
	$db->close();
}

function get_the_content($id){
	$post = get_post( $id );
	$desc = isset( $post['post_content'] ) ? $post['post_content'] : '';
	//$desc = preg_replace('/\s+/', ' ', $desc);
	
	return nl2br($desc);
}

function get_excerpt($content, $limit=8){
	/*$pattern 		= "/(<img\s+).*?src=((\".*?\")|(\'.*?\')|([^\s]*)).*>/is";
	$replacement 	= '<img width="100" src=$2>';
	$content		= preg_replace($pattern, $replacement, $content);*/
	
	$content		= strip_tags($content);
	$content		= limit_text($content, $limit);
	return $content;
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

function get_the_title($id, $set_config=false){
	$post = get_post( $id );
	$title = isset( $post['post_title'] ) ? $post['post_title'] : '';
	
	if($set_config==true) site_title($title);
	
	return $title;
}

function get_permalink($id, $ext='.html'){	
	$slug = slugify( get_the_title($id) );	
	$newUrl = base_url().'/'.$id.'-'.$slug.$ext;
	return $newUrl;
}

function get_post_permalink($id){
	return get_permalink($id);
}

function get_source_permalink($id){
	$post = get_post( $id );
	$url = isset( $post['url'] ) ? $post['url'] : '';
	return $url;
}

function get_the_excerpt($id,$maxLength=100){
	$post = get_post( $id );
	$desc = isset( $post['post_content'] ) ? $post['post_content'] : '';
	return get_excerpt(strip_tags(trim($desc)),$maxLength);
}

function get_the_date($format='Y-m-d H:i:s', $id){
	$post = get_post( $id );
	$post_date = isset( $post['post_date'] ) ? $post['post_date'] : '';
	
	$new_date = the_date($format, $post_date);
	return $new_date;
}

function insert_post($data){
	global $db;
	
	$data = array_merge($data, array('post_date' => date('Y-m-d H:i:s')));
	
	/* Since PHP 5.5 mysql_real_escape_string has been deprecated and as of PHP7 it has been removed. */
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_posts (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$res = $db->query($sql_query) or trigger_error("Error: ".$db->error, E_USER_ERROR);
	if(!$res){
		return false;
	}
	
	$id = (int) $db->insert_id;
	return $id;
}

function update_post($data,$id){
	global $db;
		
	foreach($data as $key=>$value){
		if(!empty($value)){
			$key = $db->real_escape_string($key);
			$value = $db->real_escape_string($value);
			$result[] = $key." = '".$value."'";
        }
    }
	
    $query = "UPDATE wp_posts SET ".implode(', ',$result)." WHERE ID='".$id."'";
    //print_r ($query)."<br>";
	$res = $db->query($query);
	return $res;
}

function get_imgPost($content){
	preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $image);
	$src = isset($image['src']) ? $image['src'] : '';
	return $src;
}