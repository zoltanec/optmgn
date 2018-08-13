<?php
class D_Misc_Compressor {
	static function cssCompress($css = '') {
		$css = preg_replace("/\n(\s+)/","", $css);
		$css = preg_replace("/;(\s+)/",";", $css);
		$css = preg_replace("/\/\*(.*)\*\//", "", $css);
		$css = preg_replace("/{(\s+)/", "{", $css);
		$css = preg_replace("/\}(\s+)/","}", $css);
		return $css;
	}
}