<?php
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
$encrypted_txt = $_GET['key'];
$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
$link = base64_decode($decrypted_txt);
$e = explode("@",$link);
$id = substr("$e[0]",7); 
$json = @file_get_contents("https://www.amazon.com/drive/v1/shares/".$id."?resourceVersion=V2&ContentType=JSON");
$obj = json_decode($json);
$link = $obj->nodeInfo->tempLink;
$nodo= $obj->nodeInfo->id;
if(TRUE==$link){
header("HTTP/1.1 302 Moved Temporarily");
header ("Location: ".$link."?download=TRUE");exit();
}
$json = @file_get_contents("https://www.amazon.com/drive/v1/nodes/".$nodo."/children?resourceVersion=V2&tempLink=true&shareId=".$id);
$obj = json_decode($json);
$link = $obj->data[0]->tempLink;
if(TRUE==$link){
header("HTTP/1.1 302 Moved Temporarily");
header ("Location: ".$link."?download=TRUE");exit();
}

?>