<?php
/*
 * cache/2145428.jpg, ../dist/cache/4548177.jpg
 */
	 
function get_image($file){
	$filename = explode('/', $file);
	$filename = end($filename);
	
	//return DIR_CACHE . '/' .$filename;
	return base_url().'/dist/cache/'.$filename;
}

function save_image($url,$filename){
	$image = file_get_contents($url);
	file_put_contents('/dist/cache/'.$filename, $image); //Where to save the imag
}