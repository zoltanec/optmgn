<?php
//класс для работы с ипами
class D_Net_IP extends D_Core_Object {

	const EARTH_RADIUS = 6372795;

    protected static $cachestatic = array('getIPList' => 600, 'info' => 0 );

    static protected $geoip = false;
    static protected function __fetch($id) {
        return false;
    }

    function object_id() {
        return true;
    }

    function __save() {
        return true;
    }

    static protected function __getIPList($hostname) {
        $ips = gethostbynamel($hostname);
        if($ips) {
            return implode(', ', array_unique($ips));
    	} else {
        	return '';
    	}
	}

	static function initGeoIP() {
		if(!self::$geoip) {
        	require_once D::$config->geoip_dir."/geoip.inc";
        	require_once D::$config->geoip_dir."/geoipcity.inc";
        	require_once D::$config->geoip_dir."/geoipregionvars.php";
        	self::$geoip = geoip_open(D::$config->geoip_dir."/GeoLiteCity.dat",GEOIP_STANDARD);
		}
	}

	static function between($ip1 = '', $ip2 = '') {
		self::initGeoIP();
		$info1 = geoip_record_by_addr(self::$geoip,$ip1);
		$info2 = geoip_record_by_addr(self::$geoip,$ip2);

		$lat1 = $info1->latitude * M_PI / 180;
		$lat2 = $info2->latitude * M_PI / 180;

		$long1  = $info1->longitude * M_PI / 180;
		$long2 = $info2->longitude * M_PI / 180;

		 // косинусы и синусы широт и разницы долгот
    	$cl1 = cos($lat1);
    	$cl2 = cos($lat2);
    	$sl1 = sin($lat1);
    	$sl2 = sin($lat2);
    	$delta = $long2 - $long1;
    	$cdelta = cos($delta);
    	$sdelta = sin($delta);

    	// вычисления длины большого круга
    	$y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    	$x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;
    	//
    	$ad = atan2($y, $x);
    	$dist = $ad * self::EARTH_RADIUS;

    	return intval($dist / 1000 );
	}


	static public function __info($ip = '') {
		self::initGeoIP();
		if(empty($ip)) $ip = D::$req->getIP();

		$ip_info = geoip_record_by_addr(self::$geoip,$ip);
    	//проверяем что существует результат
    	if(!empty($ip_info) AND is_object($ip_info)) {
        	if(isset($ip_info->country_name)) { $country_name = $ip_info->country_name;} else { $country_name = "Unknown";}
        	if(isset($ip_info->city)) { $city = $ip_info->city;} else { $city = "Unknown";}
        	if(isset($ip_info->country_code)) { $country_code = $ip_info->country_code;} else { $country_code = "NA";}
        } else {
            $country_name = "Unknown";
            $city = "Unknown";
            $country_code = "NA";
        }

        return array( 'country_name' => $country_name, 'city' => $city, 'country_code' => $country_code, 'geoip' => $ip_info);
	}

	//получение whois данных
    static public function whois($ip, $whois_server = "whois.ripe.net", $return_type="struct")   {
            // Соединение с сокетом TCP, ожидающим на сервере "whois.arin.net" по
            // 43 порту. В результате возвращается дескриптор соединения $sock.
            $sock = fsockopen($whois_server,43,$errno,$errstr);
            if (!$sock) {
                return false;
            } else {
                fputs ($sock, $ip."\r\n");
                $text = "";
                while (!feof($sock)) {
                    $text .= fgets ($sock, 128)."\n";
                }
                $text = str_replace("\n\n","\n",$text);
                // закрываем соединение
                fclose ($sock);
                // Ищем реферальный сервере
                $pattern1 = "|ReferralServer: whois://([^\n<:]+)|i";
                $pattern2 = "|Whois Server: ([^\n<:]+)|i";
                preg_match($pattern1, $text, $out);
                preg_match($pattern2, $text, $out2);
                if(!empty($out[1])) return IP::whois($ip,$out[1],$return_type);
                if(!empty($out2[1])) return $text.IP::whois($ip,$out2[1],$return_type);
                //whois информация окончательная. обрабатываем данные
                else {
                    if($return_type == "raw") {
                        return $text;
                    } else {
                        //разбиваем всю whois информацию на массив и обходим его
                        $whois_info=explode("\n",$text);
                        $whois_struct=array('inetnum'=>'','netname'=>'','descr'=>'','country'=>'','role'=>'','address'=>'');
                        //счетчик обработки
                        $i=0;
                        foreach($whois_info AS $w_line) {
                            //если в строке что либо есть то разбиваем ее
                            if(!empty($w_line)) {
                                //разбиваем строку на части
                                $line_data=explode(":",$w_line);
                                //удаляем лишние пустые символы
                                $line_data=array_map("trim",$line_data);
                                //заносим данные
                                switch($line_data[0]) {
                                    case "inetnum": if(empty($whois_struct['inetnum'])) $whois_struct['inetnum']=$line_data[1];break;
                                    case "descr": if(empty($whois_struct['descr'])) $whois_struct['descr']=$line_data[1];break;
                                    case "netname": if(empty($whois_struct['netname'])) $whois_struct['netname']=$line_data[1];break;
                                    case "country": if(empty($whois_struct['country'])) $whois_struct['country']=$line_data[1];break;
                                    case "role": if(empty($whois_struct['role'])) $whois_struct['role']=$line_data[1];break;
                                    case "address":
                                        if(!empty($whois_struct['address'])) { $prefix=","; } else { $prefix=""; }
                                        //формируем аддресс
                                        $whois_struct['address'].=$prefix.$line_data[1];break;
                                }
                            }
                            $i++;
                        }
                        //добавляем аддресс найденный по реверсу
                        $whois_struct['hostname']=gethostbyaddr($ip);
                        return $whois_struct;
                    }
                }
            }
        }

	/**
     * Check if this IP address is routable in internet
     *
     * @param string $ip - client IP address
     */

	function valid($ip = '127.0.0.1') {
		// check for ip structure
		if(empty($ip) OR substr_count($ip,".") != 3 OR preg_match('/[^0-9\.]/',$ip) OR !preg_match('/\d.\d.\d.\d/',$ip)) {
           	return false;
		}

		// check if ip is routable
		if ( $ip != long2ip(ip2long($ip))) {
			return false;
		}

		$reserved_ips = array (
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
		);

		foreach ($reserved_ips as $r) {
			$min = ip2long($r[0]);
			$max = ip2long($r[1]);
			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) { return false; }
		}
		return true;
	}
}
?>