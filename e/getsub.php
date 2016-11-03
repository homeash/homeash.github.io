<?php
################
#  Nghiepanthi
#  01/2015
################
header('Content-Type: text/x-subrip; charset=utf-8');
function getpage($url, $referer, $timeout, $header){
    if(!isset($timeout))
       $timeout=400; 
    $curl = curl_init(); 
    if(strstr($referer,"://")){
        curl_setopt ($curl, CURLOPT_REFERER, $referer); 
    }
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout); 
    curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}

$sub = $_GET['linksub'];
$content = "WEBVTT"."\r\n\n";
$content .= getpage($sub,'','','');
$content = strip_tags($content);
$content = preg_replace("/\n\d{1,4}\r/",'',$content);
echo $content;
?>