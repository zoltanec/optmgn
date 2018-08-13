<?php

$T['msg'] = "Please select import file.";

if ( isset(D::$req->uploaded->files['lang_file']) ) {
	$file = D::$req->uploaded->files['lang_file'];

	$h = fopen($file->tmp_name,"r");
	
	$lang = null;
	$T['msg'] = "Imported succefully!";
	
	while ( ($line = fgets($h)) ) {
		
		$line = preg_replace("/([\s\n\r\t])/i","",$line);
		
		if ( $line == '' ) continue;
		
		if ( preg_match('/^@@([a-z]{2})/i',$line,$out) ) {
			$lang = $out[1];
			continue;
		} else if ( $lang == null ) {
			continue;
		}

		if ( preg_match('/^@([\~_\-A-Z]{2,})/i',$line,$out) ) {
			if ( substr($out[1],0,1) == '~' ) {
				$msg_code = substr($out[1],1);
				$msg_js = 1;				
			} else {
				$msg_js = 0;
				$msg_code = $out[1];
			}
		} else {
			$T['msg'] = "file format corrupt!";
			break; // error !
		}

		$line = fgets($h);
		$line = preg_replace("/([\n\r\t])/i","",$line);
		
		D::$db->exec("REPLACE INTO #PX#_core_messages VALUES('{$msg_code}','{$lang}','','{$line}',0,0,{$msg_js})");
		
		
	}
	
}

?>