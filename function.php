<?php
// Sort function
function random_number($length){
    return join('', array_map(function($value) { return $value == 1 ? mt_rand(1, 9) : mt_rand(0, 9); }, range(1, $length)));
}

//include_once ('app/library/Post.php');
//include_once ('app/library/User.php');
//include_once ('app/library/Category.php');

function file_get_contents_curl($url) {
	$parse 		= parse_url($url);
	$referer 	= $parse['scheme']."://".$parse['host'];	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
	$result = curl_exec ($ch);
	curl_close ($ch);
	
	return $result;
}