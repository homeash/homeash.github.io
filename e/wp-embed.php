<?php 

/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
     // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
$encrypted_txt = $_GET['url'];
$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
$link = base64_decode($decrypted_txt);
$e = explode("@",$link);
//$uu = $e[0];
//$ee = explode("&",$uu);
$u = $e[0];
$suben = $e[1];
//echo $suben;
$domain = $e[2];
$allowed_domains = $domain;
$allowed = false;
    if (preg_match("/$allowed_domains/", $_SERVER['HTTP_REFERER'])) {
        $allowed = true;
    } 
if ($allowed) 
{
	
	if (preg_match("/drive/",$u)){
	include("google.php");		
	}
	elseif (preg_match("/photos/",$u)){
	include("photos.php");	
	}
	elseif (preg_match("/picasaweb/",$u)){
	include("picasa.php");	
	} 
	elseif (preg_match("/youtube/",$u)){
	include("youtube.php");	
	} 
	elseif (preg_match("/mp4post/",$u)){
	include("mp4.php");	
	}
    elseif (preg_match("/amazon/",$u)){
	include("amazon.php");	
	} 
    elseif (preg_match("/mp4upload/",$u)){
	include("mp4upload.php");	
	}	
	
}	else exit;

?>


