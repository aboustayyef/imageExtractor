<?php 

	require "../vendor/autoload.php";

	$test = new \Aboustayyef\ImageExtractor('http://www.beirutista.co/2015/10/sweet-reflections-from-my-birthday.html',null);
	echo $test->get(300); 
	
?>
