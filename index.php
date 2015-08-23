<?php 

	require "vendor/autoload.php";
	
	$test = new \Aboustayyef\ImageExtractor('http://blogbaladi.com/what-the-hell-happened-yesterday-in-riad-el-solh/');

	echo $test->get(400); // minimum width = 200
?>