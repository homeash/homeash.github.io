<?php
$inboxf = $_GET['url'];
$plain_txt = base64_encode($inboxf.'@'.$_SERVER['HTTP_HOST']);
$string = $plain_txt;
$encrypt_method = "AES-256-CBC";
$secret_key = 'This is my secret key';
$secret_iv = 'This is my secret iv';
// hash
$key = hash('sha256', $secret_key);
// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
$iv = substr(hash('sha256', $secret_iv), 0, 16);
$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
$output = base64_encode($output);
$encrypted_txt = $output;
$urlen = $encrypted_txt;
echo '<iframe style="border: 0px #FFFFFF none;" src="//static.detol.net/e/wp-embed.php?url='.$urlen.'" width="100%" height="100%" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
?>