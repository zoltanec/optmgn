<?php 
class Core_Debug {

	/**
	 * Принт в шаблон
	 */
	static function dprint($dmsg) {
		
		global $T;
		
		if ( !isset($T['dout']) ) {
			
			$T['dout'] = $dmsg;
		} else {
			
			$T['dout'] .= $dmsg;
		}
	}
	
	/**
	 * Рендер дебуг шаблона dit:core;admin/debug
	 */
	
	static function dbg_render() {
		D::$tpl->show('dit:core;admin/debug');
	}

}

?>