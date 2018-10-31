<?php
/*
 * Developer : Agus Puryanto
 * Email : aguspuryanto@gmail.com
 */
 
if (!function_exists('base_url')){
	function base_url(){
		global $config;
		return $config['site_url'];
	}
}

function site_info($title){
	global $config;
	
	switch ($title){
		case "title":
			return $config['site_title'];
			break;
		case "keywords":
			return $config['site_keywords'];
			break;
		case "description":
			return $config['site_description'];
			break;
	}
}

function site_title($str){
	global $config;
	$config['site_title'] = $str;
}

function site_keywords($str){
	global $config;
	$config['site_keywords'] = $str;
}

function site_description($str){
	global $config;
	$config['site_description'] = $str;
}

/**
 * Get the current Url taking into account Https and Port
 * @link http://css-tricks.com/snippets/php/get-current-page-url/
 * @version Refactored by @AlexParraSilva
*/
function getUrl() {
	$pageURL = (strtolower($_SERVER["HTTPS"]) == "on") ? "https://" : "http://";
    if ($_SERVER["SERVER_PORT"] != "80")    {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }

	return $pageURL;
}