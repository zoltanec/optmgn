<?php
class D_Core_Filesystem {
	static function getDirListing($dir_path, $files_only = true) {
		$content = array();
		if (is_dir($dir_path)) {
			if ($dh = opendir($dir_path)) {
				while (($file = readdir($dh)) !== false) {
					if($file != '.' && $file != '..') {
						$type = (is_dir($dir_path."/".$file)) ? 'dir' : 'file';
						if($files_only && $type == 'file' ) {
							$content[] = array('name' => $file, 'type' => 'file');
						} else {
							$content[] = array('name' => $file, 'type' => $type);
						}
					}
				}
				closedir($dh);
			}
		}
		return $content;
	}

	static function rmdir($dir) {
		$listing = self::getDirListing($dir);
		foreach($listing AS $obj) {
			if( $obj['type'] == 'file' ) {
				unlink($dir."/".$obj['name']);
			} else {
				self::rmdir($dir."/".$obj['name']);
			}
		}
		return true;
	}


	/**
	 * Линкует все файлы из одной директории в другую.
	 *
	 * @param $from	- каталог откуда линкуем все файлы.
	 * @param $to - каталог куда линкуем файлы
	 * @param $dbg - показывать отладочную информацию
	 * @param $recursive - линковать сабдиректории рекурсивно
	 * @param $overwrite - перезаписывать/перелинковывать файлы если они уже существуют
	 * @param $symlink - true - симолическая ссылка false - хардлинк если неудается создать ссылку файл копируется.
	 */
	static function link_files($from,$to,$dbg=false,$recursive=true,$overwrite=false,$symlink=false){

		$dbgout = array();

		if ( !file_exists($to)) {

			mkdir($to,0775,true);

		}

		if ($dbg) {
			$dbgout[]="<br>Directory link from = ".$from;
			$dbgout[]="<br>Directory link to = ".$to;
		}

		if ($handle = opendir($from)) {

			while (false !== ($entry = readdir($handle))) {

				if ( $entry == '.' || $entry == '..' ) continue;

				if ( is_dir($from."/".$entry) && $recursive ) {

					if ( file_exists($to."/".$entry) && $overwrite ) {

						$subout = D_Core_Filesystem::link_files($from."/".$entry,$to."/".$entry,$dbg,$recursive,$overwrite,$symlink);

						$dbgout = array_merge($dbgout,$subout);

					} else if ( !file_exists($to."/".$entry) ) {

						$subout = D_Core_Filesystem::link_files($from."/".$entry,$to."/".$entry,$dbg,$recursive,$overwrite,$symlink);

						$dbgout = array_merge($dbgout,$subout);

					} else {
						if ($dbg) $dbgout[]="<br>-->already exists directory, skipping =".$to."/".$entry;

					}
				} else if ( is_file($from."/".$entry) && ( !file_exists($to."/".$entry) || $overwrite ) ) {
					if ($dbg) $dbgout[]="<br>-->linking =".$from."/".$entry." to ".$to."/".$entry;

					if (file_exists($to."/".$entry)) {
						unlink($to."/".$entry);
					}

					if ($symlink) {
						$result = symlink($from."/".$entry,$to."/".$entry);
					} else {
						$result = link($from."/".$entry,$to."/".$entry);
					}
					if(!$result) {
						$result = copy($from."/".$entry, $to."/".$entry);
					}
				} else {
					if ($dbg) $dbgout[]="<br>-->already exists, skipping = ".$entry;

				}
			}
		}
		return $dbgout;
	}
}


?>
