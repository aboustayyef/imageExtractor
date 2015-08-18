<?php 

	require "vendor/autoload.php";
	
	$test = new \Aboustayyef\ImageExtractor('http://chocolateandvanillasoles.com/2015/08/18/a-basket-or-a-bag/');

	echo $test->get(400); // minimum width = 200
?>