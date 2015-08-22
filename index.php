<?php 

	require "vendor/autoload.php";
	
	$test = new \Aboustayyef\ImageExtractor('http://blogbaladi.com/youstink-saturday-protest-should-we-join-or-not/');

	echo $test->get(400); // minimum width = 200
?>