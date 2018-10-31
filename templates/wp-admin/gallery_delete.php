<?php
$file_name 		= $_POST['filename'];
var_dump ($file_name);
	
if(file_exists($file_name)){
	unlink($file_name);
}

?>