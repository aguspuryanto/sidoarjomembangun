<?php
/*
 * Check for Duplicate entries :
 * SELECT DISTINCT(post_title) AS field, COUNT(post_title) AS fieldCount FROM wp_posts
 * GROUP BY post_title HAVING fieldCount > 1
 *
 * Remove Duplicate Queries :
 * DELETE FROM wp_posts USING wp_posts, wp_posts AS vtable WHERE
 * (wp_posts.ID > vtable.ID)
 * AND (wp_posts.post_title=vtable.post_title);
 */

$app->get('/berita/insert(/)', function () use ($app, $db) {    
	
	$cache_path 	= "cdn";
	$cache_file 	= $cache_path . "/kejari-sidoarjo.xml";
	$filemtime 		= @filemtime($cache_file);
	
	if(!file_exists($cache_file) || (time() - $filemtime > 86400)){
		$xml = file_get_contents('http://kejari-sidoarjo.go.id/feed/', false);
		file_put_contents($cache_file, $xml);
	}
	
	$xml = simplexml_load_file($cache_file);	
	foreach($xml->channel->item as $item){		
		$data = array(
			'post_author' => 1,
			'post_date' => date('Y-m-d H:i:s', strtotime($item->pubDate)),
			'post_excerpt' => $db->escape_string($item->description),
			'post_content' => (string) $item->children('content', true)->encoded,
			'post_title' => $db->escape_string($item->title),
			'post_status' => 'publish',
			'post_name' => slugify($item->title),
			'post_terms' => 9,
			'post_parent' => 0,
			'guid' => $item->link,
			'post_type' => 'post'
		);
		
		/* Since PHP 5.5 mysql_real_escape_string has been deprecated and as of PHP7 it has been removed. */
		$columns = implode("`, `", array_keys($data));
		$escaped_values = array_values($data);
		$values  = implode("', '", $escaped_values);
		
		$log[] = $data;
		// CEK DUPLICATE
		$duplicate = $db->query("select count(post_name) as num FROM wp_posts WHERE post_name='".slugify($item->title)."'");
		if($duplicate===true){
			$sql_query = "INSERT IGNORE INTO wp_posts (`".$columns."`) VALUES ('".$values."')";
			
			$res = $db->query($sql_query);
		}
	}
	
	//var_dump ($log);
	echo "- last updated: " . date('F d Y h:i A', $filemtime);
});