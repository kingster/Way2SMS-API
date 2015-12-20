<?php
//http://zzz.rezo.net/HowTo-Expand-Short-URLs.html
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://way2sms.com");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$a = curl_exec($ch);
if(preg_match('#Location: (.*)#', $a, $r))
	$way2sms = trim($r[1]);
	echo $way2sms;
?>