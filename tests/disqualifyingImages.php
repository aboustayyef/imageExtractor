<?php 

	require "../vendor/autoload.php";

	$test = new \Aboustayyef\ImageExtractor('http://blogbaladi.com/netflix-might-be-launching-in-the-middle-east-soon/');

	echo "Without Disqualification: ".PHP_EOL;
	echo $test->get(300) . PHP_EOL ; 

	echo "With 1 Disqualification:" . PHP_EOL;
	$test->disqualify('http://blogbaladi.com/wp-content/uploads/2015/10/netflix-logo.jpg');
	echo $test->get(300) . PHP_EOL ; 
	
	echo "With 2 Disqualifications:" . PHP_EOL;
	$test->disqualify('http://blogbaladi.com/wp-content/uploads/2015/10/netflix1.jpg');
	echo $test->get(300) . PHP_EOL ; 

	echo "With 3 Disqualifications:" . PHP_EOL;
	$test->disqualify('http://blogbaladi.com/wp-content/uploads/2014/05/BB-Banner-3.jpg');
	echo $test->get(300) . PHP_EOL ; 

	// minimum width = 200
?>
