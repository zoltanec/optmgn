<?php
class D_Misc_Url extends D_Core_Object {

	public static $cachestatic = array('FetchDocument' => 5);
    
    static function curlRequest($post_data, $options = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.0 (Windows NT 5.1; U; en");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	
        if(isset($options['cookie'])) {
        	curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie']);
        	curl_setopt($ch, CURLOPT_COOKIEJAR,  $options['cookie']);
        }
        
        if(isset($options['referer'])) {
        	curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        
        if(is_array($post_data) && sizeof($post_data) > 0 ) {
        	$data = array();
        	foreach($post_data AS $name => $value) {
        		$data[] = "$name=".urlencode($value);
        	}
        	$post_string = implode('&', $data);
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        }
        
        if(is_string($post_data)) {
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        
        if(isset($options['sleep'])){
          sleep($options['sleep']);
        }
        
        return $ch;
    }

    static function __FetchDocument($url, $post_data = array(), $options = []) {
        
        $ch = static::curlRequest($post_data, $options);
        curl_setopt($ch, CURLOPT_URL,$url);
        
        $result = curl_exec($ch);
        
        if(!$result) {
        	throw new D_Core_Exception("Recieved bad data. cURL:".curl_error($ch), EX_OTHER_ERROR);
        }
        
        //закрываем CURL
        curl_close($ch);
       
        if(isset($options['input_encoding']) && isset($options['output_encoding'])) {
            return iconv($options['input_encoding'],$options['output_encoding'], $result);
        } else {
            return $result;
        }
    }
    
    static function curlInfo($url, $post_data = array(), $options = []) {
        
        $ch = static::curlRequest($post_data, $options);
        curl_setopt($ch, CURLOPT_URL,$url);
        
        $response = curl_exec($ch);
        
        if(!$response) {
        	throw new D_Core_Exception("Recieved bad data. cURL:" . curl_error($ch), EX_OTHER_ERROR);
        }
            
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        return $info;
    }

    static function __fetch() {
    	return false;
    }

    protected function __object_id() {
    	return false;
    }

    protected function __save() {
    	return false;
    }
}
?>