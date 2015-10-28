<?php 
/*
	Ignores images that are very wide (w/h > 4)
	marmite et pompom header is very wide. It should be ignored.
 */
	require "../vendor/autoload.php";
	$br = PHP_EOL;
	$test = new \Aboustayyef\ImageExtractor('http://marmiteetponpon.com/2015/10/28/make-your-own-all-natural-energy-drink/');

	echo $test->get(300) . $br ; 
	
?>
