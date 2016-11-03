<?php
require_once('Class-Photo.php');
$id = $u;
$megafile = new GooglePhoto($id);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8"/>
<meta name="robots" content="noindex" />
<META NAME="GOOGLEBOT" CONTENT="NOINDEX" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script type="text/javascript" src="//ssl.p.jwpcdn.com/player/v/7.3.6/jwplayer.js"></script>
<script type="text/javascript" src="https://content.jwplatform.com/libraries/uJpqcdAZ.js"></script>
<script type="text/javascript">jwplayer.key = "ABCdeFG123456SeVenABCdeFG123456SeVen==";</script>
</head>
<body>
<div id="container" class="container"></div>
<script type="text/javascript">
var playerInstance = jwplayer("container");
playerInstance.setup({
width: "100%",
height: "100%",
controls: true,
displaytitle: false,
//flashplayer: "http://p.jwpcdn.com/player/v/7.3.6/jwplayer.flash.swf",
aspectratio: "16:9",
fullscreen: "true",
//primary: 'html5',
provider: 'http',
autostart: false,
abouttext: "Google Video Player",
aboutlink: "http://wpplayer.org/",
image:'<?php echo $megafile->thumb(); ?>',
sources: [<?php echo $megafile->get(); ?>],
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

});
playerInstance.addButton(
									//This portion is what designates the graphic used for the button
									"http://i.imgur.com/cAHz5k9.png",
									"Download Video",
									function() {
										//window.location.href = playerInstance.getPlaylistItem()['file'] + '&type=fullepisodes';
										var kI = playerInstance.getPlaylistItem(),
											kcQ = playerInstance.getCurrentQuality();
										if(kcQ < 0) { kcQ =0;}
										var kF = kI.sources[kcQ].file+"?itag="+kcQ+"&type=video/mp4&title=WpPlayerDL";
										window.open(kF,'_blank');
									},
									"download"
								);	

</script>
</body>
</html>