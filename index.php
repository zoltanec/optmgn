<?php
date_default_timezone_set("Asia/Yekaterinburg");
require_once 'configs/core.php';
require_once $cfg['dcmspath']."/init.php";
class D extends D_Core_Runner {
	static function user_browser() {
    
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      $agent = $_SERVER['HTTP_USER_AGENT'];
      preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $browser_info);
      if(count($browser_info)) {
        list($browser,$version) = $browser_info;
        if ($browser == 'Opera' && $version == '9.80') {
          $version=substr($agent,-5);
        }
        if ($browser == 'Version'){
          $browser='Safari';
        }
        if (!$browser && strpos($agent, 'Gecko')) $browser='Gecko';
        return array('browser'=>$browser,'version'=>$version);
      }
		}
	}
}
D::init($cfg);
$brw=D::user_browser();//get_browser(null, true);
if($brw['browser']=='MSIE' && $brw['version']<7){
	D::$tpl->redirect("/ee_error.html");
}
D::run();
?>