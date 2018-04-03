<?php
	$x = 'a:2:{s:7:"heading";s:19:"This is a test page";s:4:"copy";s:44:"Some stuff and things\r\n\r\nAnd more things";}';
$x = nl2br($x);

	$data = unserialize($x);

echo $x;

	echo "<pre>";
	print_r($data);
	echo "</pre>";
?>