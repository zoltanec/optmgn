<?php
class D_Misc_Text {
	static protected $smilesRewriter = false;
	//список преобразований смайлов
	public $smiles_rewrite_list = array();
	//экземпляр класса
	static private $instance = false;


	/**
	 * Конструктор класса
	 */
	function __construct() {
		foreach(D::$config->smiles_list AS $smileCode => $smileFile ) {
			$this->smiles_rewrite_list[$smileCode] = '<img src="'.D::$config->smiles_path.'/'.$smileFile.'">';
		}
	}

	static protected function getInstance() {
		if(!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	static function getSmilesList($groupsize = 0) {
		return D::$config->smiles_list;
	}

	static function setSmilesList($smiles = array()) {
		self::$smilesList = $smiles;
	}

	static function parseSmiles($text) {
		$inst = self::getInstance();
		return str_replace(array_keys($inst->smiles_rewrite_list), array_values($inst->smiles_rewrite_list), $text);
	}

	static function getClearPart($text = '', $length = 40) {
		if( mb_strlen($text) > $length ) {
			$preview_clear = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags(addslashes($text)));
			$preview = trim($preview_clear);
			if(mb_strlen($preview) > $length) {
				$space_pos = strpos($preview,' ', $length);
				if($space_pos === false || $space_pos > $length) {
					$space_pos = $length;
				}
				return mb_strcut($preview, 0, $length)."...";
				//return "G".$new_data;
				//return $preview;
    		}
    		return $preview;
		} else {
			return $text;
		}
	}

	static function bbParse($text) {
		$from = array('/\[\[(.*)\]\]: #(\d+)/','/#(\d+)/','/<img src="{SMILIES_PATH}\/(.*)" alt="(.*)" title="(.*)" \/>/','/<!-- s(.*) -->/','/&quot;/');
		$to = array('[b]\1[/b] #\2','[url="#\1"]#\1[/url]', D::$config->smiles_path.'\1', '','"');
		$text = preg_replace($from,$to,$text);
    	$bb = new bbcode($text);
    	return self::parseSmiles($bb->get_html());
	}
}
?>