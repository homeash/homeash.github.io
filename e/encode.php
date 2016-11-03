<!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>@2016|detol.net</title>
<link rel="icon" href="/html5.ico" type="image/x-icon" />
</head>
<body>
<form action="" method="POST">
Link video :<input type="text" size="100" name="url"/><br><br>
Subtitle: http://wpplayer.org/e/X-Men2.srt<br><br>
Link subittles :<input type="text" size="50" name="suben"/><br><br>

Lock iframe  : www.detol.net<br><br>
Domain :<input type="text" size="50" name="domain" value="www.detol.net"/><br><br>
<br/>
<br/>
<input type="submit" value="SUBMIT"/>
</form>
<br/><br/>
<br/>
<?php
$u =  ($_POST['url']);
$subt = ($_POST['suben']);
$domain = ($_POST['domain']);
$inboxf = $u.'@'.$subt.'@'.$domain;

    $plain_txt = base64_encode($inboxf);
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

echo '<textarea rows="35" cols="100" >
<center><div class="movieplay"><iframe style="border:0px #FFFFFF none;" scrolling="no" frameborder="0" marginheight="0px" marginwidth="0px" height="100%" width="100%" src="//static.detol.net/e/wp-embed.php?url='.$urlen.'" allowfullscreen></iframe></div><center/>
</textarea>';
?>
</body>
</html>