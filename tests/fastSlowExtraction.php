<?php 

	require "../vendor/autoload.php";
	$br = PHP_EOL;
	$test = new \Aboustayyef\ImageExtractor('https://roussweetcorner.wordpress.com/2015/10/25/bittersweet-chocolate-torte/');

	echo $test->get(300) . $br ; 
	
?>
