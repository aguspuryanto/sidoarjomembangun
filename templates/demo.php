<?php
foreach($data as $berita){
	//var_dump ($data);
	$columns = implode("`, `",array_keys($berita));
	//$escaped_values = array_map('mysql_real_escape_string', array_values($data));
	$values  = implode("', '", array_values($berita));
	$sql_query = "INSERT IGNORE INTO `wp_posts` (`$columns`) VALUES ('$values')";
	echo ($sql_query)."<br>";
	//$db->query($sql_query) or trigger_error("Query Failed! SQL: $sql_query - Error: ". mysqli_error($db), E_USER_ERROR);
}

