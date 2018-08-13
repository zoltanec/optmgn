<?php
class D_Misc_Whois {
 //получение whois данных
    static function getInfo($addr, $whois_server = "whois.ripe.net", $return_type="struct") {
    	$sock = @fsockopen($whois_server,43,$errno,$errstr);
    	// exit if we can't connect to RIPE
    	if (!$sock) { throw new D_Core_Exception("Can't connect to whois server at {$whois_server}.", EX_OTHER_ERROR); }

    	// send info about our IP
        fputs ($sock, $addr."\r\n");
        $text = "";
        // read all info from socket
        while (!feof($sock)) { $text .= fgets ($sock, 128)."\n"; }
        fclose($sock);

        $text = str_replace("\n\n","\n",$text);
        // Ищем реферальный сервере
        $pattern1 = "|ReferralServer: whois://([^\n<:]+)|i";
        $pattern2 = "|Whois Server: ([^\n<:]+)|i";
        $pattern3 = "|refer: ([^\n<:]+)|i";

        preg_match($pattern1, $text, $out1);
        preg_match($pattern2, $text, $out2);
        preg_match($pattern3, $text, $out3);


        if(!empty($out1[1])) return self::getInfo($addr, trim($out[1]), $return_type);
        if(!empty($out2[1])) return $text.self::getInfo($addr,trim($out2[1]), $return_type);
        if(!empty($out3[1])) return self::getInfo($addr, trim($out3[1]), $return_type);

        return $text;
    }
}
?>