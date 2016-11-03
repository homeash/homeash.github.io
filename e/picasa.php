<?php
Function get_curl_x($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;}
Function picasa_direct($link){
			$id = explode('#',$link);
            $id = $id[1];
            $datazs = get_curl_x($link);
            $data = explode('shared_group_'.$id,$datazs);
            $data = explode('shared_group_',$data[1]);
            $data = $data[0];
            $data = explode('image/',$data);
            $data = explode('description',$data[1]);
            $data = $data[0];
                if(strpos($link , 'directlink') !== false){ 
				    $data = explode('image/',$datazs);
                    $data = explode('description',$data[1]);
                    $data = $data[0];
				    $datar= explode('"url":"', $data);
                }else{
                    if($data != ''){$datar= explode('"url":"', $data);
                    }else{//gphoto$id":"$id
                        $datav = explode('gphoto$id":"'.$id,$datazs);
                        $datav = explode('gphoto$id":"',$datav[1]);
                        $datav = $datav[0];
						$data = explode('image/',$datav);
                        $data = explode('description',$data[1]);
                        $data = $data[0];
                        $datar= explode('"url":"', $datav);
                    }
                }
			$html = '';	
            for($i=1;$i<count($datar);$i++){
                if(strpos($datar[$i], 'video/mpeg4') !== false){
                    $datarz = explode('"', $datar[$i]);
                    $typep = explode('"height":', $datar[$i]);
                    $typep = explode(',', $typep[1]);
                    $typep = $typep[0];
                    $datarss = $datarz[0]; 
                    $htmls = $datarss;
                    $htmls = str_replace('&','&amp;',$htmls);
				    $html .= '{file:"'.$htmls.'",label:"'.$typep.'p",type: "video/mp4"},';
				}
                
                }
				 return $html;
            }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">
<head>
<meta charset="UTF-8"/>
<meta name="robots" content="noindex" />
<META NAME="GOOGLEBOT" CONTENT="NOINDEX" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script type="text/javascript" src="https://content.jwplatform.com/libraries/uJpqcdAZ.js"></script>
<script type="text/javascript">jwplayer.key = "ABCdeFG123456SeVenABCdeFG123456SeVen==";</script>
<style type="text/css">
*{margin:0;padding:0}#picasa{position:absolute;width:100%!important;height:100%!important}
</style>
</head>
<body>
<div>
<center>
<div id="picasa" class="picasa"></div>
<script type="text/javascript">
	var playerInstance = jwplayer("picasa");
		playerInstance.setup({
		id:'picasa',
		controls: true,
		displaytitle: true,
		//flashplayer: "http://p.jwpcdn.com/player/v/7.3.6/jwplayer.flash.swf",
		width: "100%",
		height: "100%",
		aspectratio: "16:9",
		fullscreen: "true",
		//primary: 'html5',
		provider: 'http',
		autostart: false,
		abouttext: "Google Video Player",
        aboutlink: "http://wpplayer.org/",
		sources: [<?php echo $file = picasa_direct($u); ?>],
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
</center>
</div>
</body>
</html>
