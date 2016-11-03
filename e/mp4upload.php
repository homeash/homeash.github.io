<?php 
error_reporting(E_ERROR | E_PARSE);
$uuu = substr("$u",10);
$linkm = $uuu;
function getIdYoutube($linkm){
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=mp4upload.com/)[^&\n]+#", $linkm, $id);
    if(!empty($id)) {
        return $id = $id[0];
    }
    return $linkm;
}
$id = getIdYoutube($linkm);
function curl($url) {
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$head[] = "Connection: keep-alive";
	$head[] = "Keep-Alive: 300";
	$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$head[] = "Accept-Language: en-us,en;q=0.5";
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	$page = curl_exec($ch);
	curl_close($ch);
	return $page;
}
$um = curl('http://www.mp4upload.com/embed-'.$id.'.html');
$url = curl('http://www.mp4upload.com/'.$id);
$mp4 = explode("'file': '", $um);
$mp4 = explode("',", $mp4[1]); 
$img = explode("'image': '", $um);
$img = explode("',", $img[1]);
$title = explode('<span class="dfilename">', $url);
$title = explode('</span>', $title[1]);
$title = str_replace(".mp4","",$title[0]); 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8"/>
<?php
if($title!=''){ echo '<title>'.$title.'</title>'; }
?>

<link rel="shortcut icon" type="image/x-icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAAA9CAYAAAAd1W/BAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAIGNIUk0AAHolAACAgwAA+f8AAIDoAABSCAABFVgAADqXAAAXb9daH5AAAAKGSURBVHja7NpLaxNRFAfwfIGqSZPMTOZ902SaNE3GryO4E9y5UsSFuNRNRcGN+KBUEUVFVKQqWLWCRBeaInRh8d1KoVE/wt/VyECdYW6Ted2exX89c37knjvn3hQAFHZzCgRAAARAAARAAARAAARAAAQwch41avjlsn9Z79q4bFUhPMBFs4o/++uBGboMVy0JQgLcYHJo8f5s9GyckIsQCiBq8f68aekQAuDzrIWdAHh5MFVDrgFGKd7fH87pFexaAC9fZi0IB/Cja3ND9BPuD7EAbLkMzx0NR6r7cJPJWOvw94rrtozcAqx2zG0v/7SpYidNM5cAK20j8MUXGzX87PEtjU8x9od4AGaM0Bc+Jhex5KjcEI8bKoQA8HJUKuLVtJbqskgVwMtpdRLLDh/ElssgDICXOb2MQdtI9LM6UwBeLhgVboj7UwqEAfByyaziG8fH1Ps2/3MzDQCgcKA0gXlLwnpEiNt1vl9C5gH8uVtXxr5L5ArAy5KjYuiyQICzehlCAwAofJgxx3LOkFuAfksPBHjSVMUGOFUr4XtIU1ywJTEBDpX34F5dwe+Q9S9kEzw4OYE7dSXS8LTWscQCuGJJ+Nq1YhuUMguwYEtY7ZixT4mZAzivV7DCOQc8HOF4PTMAc3oZb0O2tnGs90wCnFRKeD2tp3YokhrAcbmIfkvHZo9xFX7NlrJ/IjQIGUsPV/Zi2dGwwXke+MLRkJtD0XcBAM+aKtd8P86jr8QAhi7DGW37NPaRc0vjneoycz1+i/3/Roen8MVGcrfGid3BRSl80DYSKzxTAJs9lnjhiQMEbXfzKf93KNGH+W+JX8a0rdH/BAmAAAiAAAiAAAiAAAggWv4OAI9sgX7ix1myAAAAAElFTkSuQmCC"/>
<meta name="robots" content="noindex" />
<META NAME="GOOGLEBOT" CONTENT="NOINDEX" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script type="text/javascript" src="https://content.jwplatform.com/libraries/uJpqcdAZ.js"></script>
<script type="text/javascript">jwplayer.key = "ABCdeFG123456SeVenABCdeFG123456SeVen==";</script>
<style type="text/css">*{margin:0;padding:0}#container{position:absolute;width:100%!important;height:100%!important}</style>
</head>
<body>
<div id="container" class="container"></div>
<script type="text/javascript">
var playerInstance = jwplayer("container");
playerInstance.setup({
width: "100%",
height: "100%",
controls: true,
title: '<?php echo $title; ?>',
displaytitle: true,
//flashplayer: "http://p.jwpcdn.com/player/v/7.3.6/jwplayer.flash.swf",
aspectratio: "16:9",
fullscreen: "true",
//primary: 'html5',
provider: 'http',
autostart: false,
image:'<?php if($img[0]!=''){ echo $img[0]; } ?>',
sources: [<?php if($mp4[0]!=''){ echo "{file:'".$mp4[0]."',type: 'video/mp4',default: true}"; } ?>],
 tracks: [{ 
		    file: 'http://wpplayer.org/e/getsub.php?linksub=<?php echo $suben; ?>', 
		    label: 'English', 
		    kind: 'captions',
		    "default":true
		  }],
         captions: {
        color: '#FFFFFF',
        fontSize: 20,
        backgroundOpacity: 20
    },
logo : {file: "",
		link: "",
		hide: true,
		},

abouttext: "Google Video Player",
aboutlink: "http://wpplayer.org/",
});
jwplayer().addButton(
		"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAASCAYAAABb0P4QAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCRDc2NUM3RDFEMEMxMUUyQjU2QUFCQUEyM0JGREJGRCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCRDc2NUM3RTFEMEMxMUUyQjU2QUFCQUEyM0JGREJGRCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkJENzY1QzdCMUQwQzExRTJCNTZBQUJBQTIzQkZEQkZEIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkJENzY1QzdDMUQwQzExRTJCNTZBQUJBQTIzQkZEQkZEIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+czMQdgAAAPdJREFUeNpi+P//PwMOzATEh/9jgp149DAwMeAGjFCMTRwnwGcgLnmKDGSgpoF/yfEyCxqfDYiTgZgZiP8BsTAWPSJAnATEXFBL5wLxL7gslpidiBSj/7DE8l8kdhtUD9wMbFHPAsQ9/wmDFmzJBld64gHi83gM24juMkIGgrAaEN/AYtg1IFbGpQ+fgSBsDMT3kAy7DcR6+PQQMhCEHZEMtCeknhFsKmGQD0oQQDyJYKoHGigEpGOBWAoq9g9NDcig31A2K5aEDcvzoLS4CeTM0v/UA8dBWY+PgXqAC5T1ZgLxdyAWQvIiOQUGKKh2ExspRAOAAAMARqI5WRk9ASEAAAAASUVORK5CYII%3D",
		"Download Video",
		function(){
			window.location.href = '<?php if($mp4[0]!=''){ echo str_replace("video",$title,$mp4[0]); } ?>';
		},
		"download"
);
</script>
</body>
</html>