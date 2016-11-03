<?php

require_once("moviesclass.php");

class google extends moviesclass{
    var $match_link = "https?:\/\/(?:www\.)?(?:drive|docs)\.google\.com\/(?:file\/d\/|open\?id\=)?([a-z0-9A-Z_-]+)(?:\/.+)?";
   
    
    var $match_link2 = "https?:\/\/(?:www\.)?(?:drive|docs)\.google\.com\/folderview\?id\=([a-z0-9A-Z_-]+)[^\#]*?(?:\#(\d+))?";

    public function getid(){
    
        if($this->match_link($this->url,$m)){
            if(isset($m[1])){
                $this->id = $m[1];
            } 
            
      
        }elseif($this->match_link($this->url,$m2,$this->match_link2))  {
     
            $this->id = $m2[1];
            if(isset($m2[2])){
                $this->season = $m2[2];
            } else $this->season = 0;
    
            $this->url = "https://drive.google.com/folderview?id=".$this->id;
            $this->content = $this->curl->get($this->url,'',2);
            
            preg_match_all("/\"([a-z0-9A-Z_-]+)\",,\"https:\/\/drive\.google\.com/",$this->content, $m3);
            
            $this->url = "https://drive.google.com/file/d/".$m3[1][$this->season]."/view";
            $this->id = $m3[1][$this->season]; 
           
        }
      
    }
    
    public function getlink(){
     
        $r = rand(2,2);
        $this->content = $this->{"get_id$r"}($this->id);
        
        $this->getlinks();
    }
     
    public function getlinks(){
      
        preg_match("/\[\"fmt_stream_map\",\"([^\"]+)\"/",$this->content,$m);
        
      
        
        $this->content = "[\"". $m[1] ."\"]";
         
        $this->content = json_decode($this->content);
        $this->content = $this->content[0];
        
      
        
        $data = explode(",",$this->content);
        
      
        $quality = array(
        '22'=>720 ,
        '43'=>360 ,
        '18'=>360 ,
        '5'=>240 ,
        
        '36'=>240 ,
        '17'=>144 ,
        
        '59'=>480,
        '35'=>480,
        '34'=>360,
        '37'=>1080,
        
        '78'=> 480,
        );
      
         
        foreach ($data as $mmm) {
            $mm = explode("|",$mmm);
          
		    if(!in_array($mm[0],array(18,22,78,37,59))) continue;
			$mp4 = array('link_mp4'=>'', 'quality'=>'');
			$mp4['link_mp4']= self::link($mm[1]); //($mm[1]); //
			$mp4['quality'] = $quality[$mm[0]];  
			$this->links[] = $mp4;  
		}
        
    } 
    
    public static function link($link){
        $y2 = explode("?",$link);

        parse_str($y2[1],$t);
       
        self::shuffle_assoc($t);
        $t = http_build_query($t);
        
        $t = $y2[0]."?".$t;
        
        return preg_replace("/\/[^\/]+\.google\.com/","/redirector.googlevideo.com",$t).'&filename=video.mp4';
    }
     
    function get_id2($id){
         $u = 'https://drive.google.com/file/d/'.$id.'/view?pli=1';
 
          
         $this->curl->get('https://www.proxfree.com/','',2);
         $this->curl->httpheader = array(
         'Referer:https://de.proxfree.com/permalink.php?url=eKcKvRAsZMJp3EkmD1K78%2Bqx%2FrqnRtIHySNzmMxUbxvJ%2FxfYKDbfQTtfxlzFz63ZA2PxrVLbAzRji7PR98co4KUo8OToTy25nhXHdedVcXsUt3WZdBKH09owwj58mvXq&bit=1',
        'Upgrade-Insecure-Requests:1',
        'Content-Type:application/x-www-form-urlencoded',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Accept-Language:en-US,en;q=0.8,vi;q=0.6,und;q=0.4',
         
         );
        
         $y=( $this->curl->post('https://de.proxfree.com/request.php?do=go&bit=1','pfipDropdown=default&get='.urlencode($u),4) );
         
         
         return $this->curl->get($y[0]["Location"],'',2);
    }
     
}





  $x = new google($u);
   

   
   $xx = ($x ->links);

 ?>  
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">
<head>

<meta charset="UTF-8"/>
<meta name="robots" content="noindex" />
<META NAME="GOOGLEBOT" CONTENT="NOINDEX" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script type="text/javascript" src="http://static.detol.net/e/jwplayer/v.7.4.2/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key = "BDz5+1WpApgAoLQDFV4dQ/xVRw4yMIuTh6t7HA==";</script>
<style type="text/css">
*{margin:0;padding:0}#picasa{position:absolute;width:100%!important;height:100%!important}
</style>
</head>
<body>
<div>
<center>
<div id="picasa" class="picasa"></div>'
<script type="text/javascript">
 	var playerInstance = jwplayer("picasa");
		playerInstance.setup({
		id:'picasa',
		controls: true,
		displaytitle: true,
		//flashplayer: "http://static.detol.net/e/jwplayer/v.7.4.2/jwplayer.flash.swf",
		width: "100%",
		height: "100%",
		aspectratio: "16:9",
		fullscreen: "true",
		provider: 'http',
		autostart: false,
		abouttext: "Google Video Player",
        aboutlink: "http://detol.net/",
		
		sources: [<?php
	
foreach ( $xx as $i){
	if($i["quality"] == '1080'){
	echo '{file: "'.$i["link_mp4"].'",label:"1080p",type: "video/mp4"},';}
	else if($i["quality"] == '720'){
	echo '{file: "'.$i["link_mp4"].'",label:"720p",type: "video/mp4"},';}
	else if($i["quality"] == '480'){
	echo '{file: "'.$i["link_mp4"].'",label:"480p",type: "video/mp4",default: "true"},';}
	else if($i["quality"] == '360'){
	echo '{file: "'.$i["link_mp4"].'",label:"360p",type: "video/mp4"}';}
		
}

?>],
	
	});
	
								
					
					
		
</script>
</center>
</div>
</body>
</html>

