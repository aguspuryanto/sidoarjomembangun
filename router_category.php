<?php

$app->get('/category', function () use ($app, $db) {
	//var_dump ($app->category);
	
	$category = $app->category;
	foreach($category as $key => $terms){
		echo $key." = ".$terms."<br>";
	}
	
	echo '<br>';
	
	//$cat = get_category('peristiwa');
	//var_dump ($cat['term_id']);
});