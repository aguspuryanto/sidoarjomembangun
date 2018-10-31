<?php
if(isset($_POST)){
	//var_dump($_POST);
	//var_dump($_FILES);
	
	$file_name 		= $_FILES['gallery_files']['name'];
	$file_tmp 		= $_FILES['gallery_files']['tmp_name'];
	$file_type 		= $_FILES['gallery_files']['type'];
	$file_size		= $_FILES['gallery_files']['size'];

	$valid_file 	= false;
	$allowedExts 	= array("jpg", "png", "gif");
	$temp 			= explode(".", strtolower($file_name));
	$extension 		= end($temp);
	$uploaded 		= __DIR__ . "/uploads/" . basename($file_name);

	//can’t be larger than 1 MB
	if($file_size > (1024000)){
		echo '<div class="alert alert-warning"> Oops! Your file\’s size is to large.</div>';
		
	}elseif(file_exists($uploaded)){
		echo '<div class="alert alert-warning"> '. $file_name . ' already exists. </div>';
		
	}elseif (($file_size < 1024000) && in_array($extension, $allowedExts)){	
		$res = move_uploaded_file($file_tmp, $uploaded);
		if($res){
			echo '<div class="alert alert-success">
				File is valid, and was successfully uploaded.
			</div>';
		}
	}
}
?>