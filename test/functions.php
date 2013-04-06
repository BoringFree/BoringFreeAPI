<?php

function execute($payload, $debug = false) {

	$url = 'http://boringfree.com/api/';
//	$url = 'http://localhost/api/';
	$post = json_encode($payload);

	$arr = array();
	array_push($arr, 'Content-Type: application/json; charset=utf-8');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1 );
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	$result = curl_exec($ch);
	curl_close($ch);

	if ($debug) {
		echo "<hr>RQ:<br>";
		echo $post;
		echo "<hr>RS:<br>";
		echo $result;
	}

	return $result;

}

function debug($p) {
	echo "\n".$p;
}