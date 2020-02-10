<?php 
$url = "https://www.seznam.cz";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
echo "curl";
$output = curl_exec($curl);
var_dump($output);
curl_close($curl);