<?php
function smarty_modifier_left_time($second, $mode = "adaptive") {
	$result = array('days'=> 0, 'hours'=>0, 'minutes'=>0, 'seconds'=>0);
	//сначала считаем количество дней
	while($second >= 86400 ) {
		$second -= 86400;
		$result['days']++;
	}
	while($second >= 3600 ) {
		$second -= 3600;
		$result['hours']++;
	}
	while($second >= 60 ) {
		$second -=60;
		$result['minutes']++;
	}
	if($mode=="adaptive") {
	//формируем
         if($result['days']!=0 ) { return $result['days']." ".D::$i18n->getTranslation('DAYS')." ". $result['hours']." ".D::$i18n->getTranslation('HOURS'); }
        if($result['days'] == 0) { return $result['hours']." ".D::$i18n->getTranslation('HOURS')." ".$result['minutes']." ".D::$i18n->getTranslation('MINUTES'); }
        elseif($result['hours']!=0) { return $result['hours']." ".D::$i18n->getTranslation('HOURS'); }
        if($result['minutes']!=0 ) { return $result['minutes']." ".D::$i18n->getTranslation('MINUTES'); }
        if($result['seconds']!=0 ) { return $result['seconds']." ".D::$i18n->getTranslation('SECONDS'); }
    } else return  $result['days']." ".D::$i18n->getTranslation('DAYS')." ". $result['hours']." ".D::$i18n->getTranslation('HOURS')." ".$result['minutes']." ".D::$i18n->getTranslation('MINUTES');
}
?>