<?php

require "config.php";

$paragraph =  $_POST['mutil_url'];

preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $paragraph, $match);
$urls = $match[0];

$error = false;

foreach ($urls as $full_url) {
	$full_url = mysqli_real_escape_string($conn, $full_url);
	if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){
		$ran_url = substr(md5(microtime()), rand(0, 26), 5);
		$sql = mysqli_query($conn, "SELECT * FROM url WHERE shorten_url = '{$ran_url}'");
		if(mysqli_num_rows($sql) > 0){
			echo "Something went wrong. Please generate again!";
		}else{
			$sql2 = mysqli_query($conn, "INSERT INTO url (full_url, shorten_url, clicks) 
                                         VALUES ('{$full_url}', '{$ran_url}', '0')");
			if($sql2){
				$sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
				if(mysqli_num_rows($sql3) > 0){
					$shorten_url = mysqli_fetch_assoc($sql3);
				}
			}
		}

		$paragraph = str_replace($full_url, "https:".$domain.$ran_url, $paragraph);

	}else{
		$error = true;
	}
}

echo $paragraph;
die();
?>