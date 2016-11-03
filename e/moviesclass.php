<?php
require_once("curl.class.php");
//require_once("aes.class.php");
//require_once("picasa.class.php");

class moviesclass{
    var $url;
    var $id = false;
    var $season;
    var $link;
    var $links=array();
    var $curl;
    var $content;
    var $match_link = '';
    
    public function __construct($url='', $run = true){
        if(preg_match("/^http/",$url))
            $this->url = $url;
        else $this->id = $id;
        if($run) $this->run();
    }
    
    public function run(){
        $this->curl = new CURL;
        if(!$this->id) $this->getid();
        $this->getlink();
    }
    
    public function getid(){
        
    }
    
    public function getlink(){
        
    }
    
    public function getlinks(){
        
    }
    
    public function decode($link){
        
    }
    
    public function is_picase(){
        return preg_match("/picasaweb/",$this->link);
    }
    
   
    
    public function is_yt(){
        return preg_match("/youtube\.com/",$this->link);
    }
    
    public function is_dr(){
        return preg_match("/(drive|docs)\.google\.com/",$this->link);
    }
    
    public function picasa(){
        
    }
    
    public function match_link($url, &$m=false, $match=false){
        return preg_match("/^".($match!==false?$match:$this->match_link)."$/", $url, $m);
    }
    
    public function json(){
        $arr_data =array('link_stream'=>'','error_message'=>'');  
    	if($this->links){  
    		if(count($this->links)>0){
    			$arr_data['link_stream'] = $this->links;  
    		}else{
    			$arr_data['error_message'] = 'ERROR';
    		}
    	}else{  
    		 $arr_data['error_message'] = 'ERROR';  
    	}  
    	return (json_encode($arr_data));
    }
    
    public static function getDirectLink($url) {
        $urlInfo = parse_url($url);
        //var_dump($urlInfo);
        $out  = "GET  {$url} HTTP/1.1\r\n";
        $out .= "Host: {$urlInfo['host']}\r\n";
        $out .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
        $out .= "Connection: Close\r\n\r\n";    
        $con = @fsockopen('ssl://'. $urlInfo['host'], 443, $errno, $errstr, 20);
        if (!$con){
            return $errstr." ".$errno; 
		}
        fwrite($con, $out);
        $data = '';
        while (!feof($con)) {
            $data .= fgets($con, 512);
        }
        fclose($con);
        preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $data, $matches);
        $url = $matches[1];
        return trim($url);
    }
    
    public static function httpDirectLink($url) {
        $urlInfo = parse_url($url);
        //var_dump($urlInfo);
        $out  = "GET  {$url} HTTP/1.1\r\n";
        $out .= "Host: {$urlInfo['host']}\r\n";
        $out .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
        $out .= "Connection: Close\r\n\r\n";    
        $con = @fsockopen($urlInfo['host'], 80, $errno, $errstr, 20);
        if (!$con){
            return $errstr." ".$errno; 
		}
        fwrite($con, $out);
        $data = '';
        while (!feof($con)) {
            $data .= fgets($con, 512);
        }
        fclose($con);//var_dump($data);die();
        preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $data, $matches);
        $url = $matches[1];
        return trim($url);
    }
    
    public function DirectLink($url) {
        $c = $this->curl->get($url,'',4);
        //var_dump($c);die();
        return isset($c[0]["Location"])?$c[0]["Location"]:false;
        
        if(isset($c[0]["Location"])){
            echo $c[0]["Location"];
            $this->curl->referer = '';
            echo $this->curl->get($c[0]["Location"],'');die();
        }
    }
    
    public static function ping($ips){
        $ip = $ips[0];
        $port = $ips[1];
           
        $con = @fsockopen($ip, $port, $errno, $errstr, 10);
        if (!$con){
            return false;
		}
        return true;
    }
    

   
    public function getlinksyt(){
        require_once("youtube.php");
        //var_dump($this->link); 
        $zing = new youtube($this->link);
        $this->links = $zing->links;
    }
    
    public function getlinksdr(){
        require_once("google.php");
        $zing = new google($this->link);
        $this->links = $zing->links;
    }
    
    public static function shuffle_assoc(&$array) {
        $keys = array_keys($array);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }
        $array = $new;
        return true;
    }
}

?>