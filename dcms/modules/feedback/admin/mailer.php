!#/usr/bin/php
<?php
require_once '/var/www/soc/dynamic/configs/core.php';
require_once $cfg['dcmspath'].'/init.php';
class D extends dCoreRunner {
    static function init($cfg) {
    	spl_autoload_register(array('D','autoload'));
    	self::$framework = $cfg['dcmspath'].'/framework';
    	self::$content_path = $cfg['path'].'/content';
        self::$cache = new dXCache('c');
        	self::$db = new dMySQL('localhost', $cfg['databases']['db']['user'],
        	                                    $cfg['databases']['db']['password'],
        	                                    $cfg['databases']['db']['name'],
        	                                    self::$cache,
        	                                    $cfg['databases']['db']['prefix']);
    }
}
D::init($cfg);
$emails=D::$db->get_as_series("SELECT email FROM uszn_feedback_msg WHERE subscribe=1");
$to=implode(',',$emails[0]);
$news=D::$db->fetchlines("SELECT * FROM uszn_news");
foreach($news as $new) {
	if(date('Y.m.d',$new['addtime'])==date('Y.m.d',time())) {
		mail($to, "Рассылка сайта".$cfg['site_name'], $new['content']);
	}
}
$msg="ты лошпен";
mail($to, "Рассылка сайта".$cfg['site_name'], $msg);
//if(mail($to,$title,$content))
//foreach ($files AS $data) {
//	$name = substr($data['filename'],0, strrpos($data['filename'], '.'));
//	if(file_exists(D::$content_path.'/children/video/'.$data['filename'])) {
//		exec('ffmpeg -i '.D::$content_path.'/children/video/'.$data['filename'].' -f flv -b '.($data['size']*8*0.9/(1000*$data['duration'])).'k -ab 32k -ar 22050 -ac 1 -y '.D::$content_path.'/children/video/'.$name.'.flv');
//		unlink(D::$content_path.'/children/video/'.$data['filename']);
//		D::$db->exec("UPDATE uszn_children_media SET flag='converted' WHERE fileid='{$data['fileid']}'");
//	}
//}
?>