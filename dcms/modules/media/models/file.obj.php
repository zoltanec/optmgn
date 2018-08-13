<?php
//медиа файл
class Media_File extends D_Core_Object {
	static protected $cacheable = array('prevnext'=> 60, 'next'=> 60, 'prev'=> 60, 'instance' => 0, 'parent' => 0);
	static public $cacheself = 10;
	static public $typesExtensions = array('picture' => array('jpg', 'jpeg', 'png', 'gif'), 'video' => array('avi','flv','mpg', 'mpeg', 'mp4','ts'), 'audio' => array('mp3', 'wma'));
	
	static public $id_naming = '#size#-#size_x#x#size_y#-#time#.#ext#';
	static public $naming = '#dirnamerus#-#size_x#x#size_y#';
	
  static public $setting;
  
	public $fileid;
	public $parentid;
	public $filename;
	//размер медиафайла
	public $filesize = 0;
	//тип медиафайла
	public $type = 'unknown';
  public $active;
  public $descr;
  public $variants;
  public $priority = 0;
	protected $file_path = '';

    function __construct() {
        if(isset($this->fileid) AND isset($this->parentid)) {
            //создаем идентификатор объекта для сохранения статистики промотров и комментариев
            $this->object_id = 'media-'.$this->parentid.'-'.$this->fileid;
        } else {
        	//по умолчанию мы инициализируем всякой ерундой
        	$this->fileid = md5(rand());
        }
		if(!Core_SettingValue::$module)
			$this->save_path = 'media';
		else $this->save_path = 'images/' . Core_SettingValue::$module;
		
    if(!Core_SettingValue::$object)
      self::$setting = D::$config->setting;
    else self::$setting = D::$config->{'obj_' . Core_SettingValue::$object};
		//Проверяем настройки сжатия, иначе берем из core, либо по умолчанию из класса
		$this->checkSettings();
    }
	
	function __destruct(){
		Core_SettingValue::$module = false;
    Core_SettingValue::$object = false;
	}
	
    /**
     * Build new object
     *
     * @param string $parentid - media dir, where this file located
     * @param string $fileid - file identification
     */

  	static function __fetch($parentid = '', $fileid = '') {
    	if(strpos($parentid,':::') > 0 ) {
    		list($fileid, $parentid) = explode(':::',$parentid);
    	}
    	return D::$db->fetchobject("SELECT * FROM #PX#_media_files WHERE parentid = '{$parentid}' and fileid = '{$fileid}' LIMIT 1",__CLASS__);
    }

    /**
     * Media file identification
     */
	protected  function __object_id() {
		return array($this->parentid, $this->fileid);
	}

	/**
	 * Get parent object
	 */
	function __get_parent() {
		return D_Core_Factory::Media_Dir($this->parentid);
	}

	function __get_prevnext() {
		return  $this->parent->FindPrevNextFiles($this->fileid);
	}

	function __get_next() {
		return $this->prevnext['next'];
	}
	function __get_prev() {
		return $this->prevnext['prev'];
	}
	
    //Сохранение файла
    protected function __save() {
        D::$db->exec("INSERT INTO #PX#_media_files (fileid,parentid,filename,filesize,type,priority,descr,add_time)
			VALUES ('{$this->fileid}',
				'{$this->parentid}',
				'{$this->filename}',
				'{$this->filesize}',
				'{$this->type}',
				'{$this->priority}',
				'{$this->descr}',
				UNIX_TIMESTAMP())
			ON DUPLICATE KEY UPDATE
				parentid = '{$this->parentid}',
				filename = '{$this->filename}',
				type = '{$this->type}',
				priority = '{$this->priority}',
				active = '{$this->active}',
				descr = '{$this->descr}',
		        variants = '{$this->variants}',
				upd_time = UNIX_TIMESTAMP()");
    }

    function moves($dest_path) {
    	$dest_path = $this->replaceToMyMeta($dest_path);
    	$dest_dir = dirname($dest_path);
    	if(!is_dir(dirname($dest_dir))) {
			if(!@mkdir($dest_dir, 0777, true)) {
				throw new D_Core_Exception("COULD_NOT_CREATE_DIR:" .  $dest_dir, EX_OTHER_ERROR);
			}
		}
		if(!copy($this->file_path, $dest_path)) {
			throw new D_Core_Exception("COULD_NOT_COPY_THE_FILE:" .  $this->file_path, EX_OTHER_ERROR);
		}
	}

	//Выяснить для чего
    function getVariantsList() {
    	if(!empty($this->variants)) {
    		$variants_done = array();
    		foreach(explode("\n",trim($this->variants)) AS $variant) {
    			$variant_array = explode('===', trim($variant));
    			if(sizeof($variant_array) == 2 ) {
    				$variants_done[$variant_array[0]] = array('name' => $variant_array[0], 'url' => $variant_array[1]);
    			}
    		}
    		$parsed = array();
    		foreach(self::$additional_dimensions AS $dim) {
    			if(isset($variants_done[$dim])) {
    				$parsed[$dim] =$variants_done[$dim];
    			}
    		}
    		return $parsed;
    	}
    }

	//Выяснить для чего
	function addVariant($name, $url) {
		$parsed[$name] = array('url' => $url);
		$result = '';
		foreach($parsed AS $dim => $variant) {
			$result.= $dim."===".$variant['url']."\n";
		}
		$this->variants = trim($result);
		return true;
	}

    //Функция перемещает файл в другой каталог
	function ChangeDir ($changedir) {
		$dir = $this->parentid;
		D::$db->exec("UPDATE #PX#_media_files SET parentid = '{$changedir}' WHERE fileid = '{$this->fileid}' AND parentid = '{$dir}' LIMIT 1");
		if(!rename(D::$content_path . "/media/" . $dir . "/" . $this->fileid, D::$content_path."/media/" . $changedir."/" . $this->fileid))
			throw new D_Core_Exception("COULD_NOT_MOVE_FILE:" .  $this->fileid, EX_OTHER_ERROR);
		if(!rename(D::$content_path . "/media/thumbs/" . $dir . "/" . $this->fileid, D::$content_path . "/media/thumbs/" . $changedir . "/" . $this->fileid))
			throw new D_Core_Exception("COULD_NOT_MOVE_THUMB_FILE:" .  $this->fileid, EX_OTHER_ERROR);
	}

    //обновление приоритета файла, передаем up или down и айдишник файла
    //function UpdatePriority($mode) {
    //	($mode == 'up') ? $this->priority++ : $this->priority--;
    //	D::$db->exec("UPDATE #PX#_media_files SET priority = $this->priority WHERE fileid = '{$this->fileid}' AND parentid = '{$this->parentid}' LIMIT 1");
    //	return $this->priority;
   // }

	//Для проверки существования fileid в случае сохранения id по имени источника
	function exists() {
		$dirid = $this->parentid;
		$response = D::$db->fetchline("SELECT COUNT(1) AS count FROM #PX#_media_dirs WHERE fileid='{$this->fileid}' AND dirid = '{$dirid}'");
		if($response['count']!=0) {
			return true;
		} else return false;
	}
	
	//Если в модуле не установлены основные настройки, то берем из core
	function checkSettings() {
		$img_size = self::$setting->thumb_size;
		$thumb_size = self::$setting->img_size;
		if(!$img_size || !$thumb_size)
			Core_SettingValue::$module = 'core';
	}
	
    //инициализация новым файлом
    function from($file, $ext = false) {
		//Отчищаем данные прошлой инициализации в случае мультизагрузки
		if(isset($this->instance)) {
            //var_dump($this->instance);
			//$this->untouch('instance', true);
            //var_dump($this->instance);exit;
        }
		if(is_object($file) && get_class($file) == 'D_Core_UploadedFile') {
			//Если объект класса D_Core_UploadedFile
				$this->ext = $file->getExt();
				//Если нет шаблона именования, берем имя загружаемого файла
				if(self::$setting->fileid_from_source){
					$this->fileid = $file->name;
					if($this->exists)
						$this->fileid = $file->name . time();
				}
				$this->filesize = $file->size;
				$this->file_path = $file->tmp_name;
		} else {
			if(!file_exists($file)) {
				throw new D_Core_Exception("UNKNOWN_OBJECT_ON_INPUT:" . $file, EX_OTHER_ERROR);
			}
			if($ext) {
	    		$this->ext = $ext;
	    	} else {
				$ext = explode('.',strtolower($file));
				$this->ext = end($ext);
			}
			if(self::$setting->fileid_from_source) {
				$fiename = explode('/', strtolower($file));
				$this->fileid = end($fiename);
				if($this->exists)
					$this->fileid = $this->fileid . time();
			}
			//Указываем путь к файлу
			$this->file_path = (string)$file;
		}
    	//теперь по расширению определяем тип файла
    	foreach(self::$typesExtensions AS $type => $extensions) {
    		if(in_array($this->ext, $extensions)) {
    			$this->type = $type;
    			break;
    		}
    	}
		if(self::$setting->naming)
			self::$naming = self::$setting->naming;
		//Если нет имени файла формируем по шаблону
		if(!$this->filename)
			$this->filename = $this->replaceToMyMeta(self::$naming);
		//Если в настройках шаблон id именования
		if(self::$setting->id_naming)
			self::$id_naming = self::$setting->id_naming;
		if(!self::$setting->fileid_from_source)
			$this->fileid = $this->replaceToMyMeta(self::$id_naming);
    	return $this;
    }

    //получаем экземпляр объекта связанного с низкоуровневыми операциями над нашим медиафайлом
    function __get_instance() {
    	switch($this->type) {
    		case "picture": return new Media_PicFile($this->file_path);
    		case "video": return new VideoFile($this->file_path);
    		case "audio": return new AudioFile($this->file_path);
    		default: throw new Exception('WRONG_MEDIA_FILE_TYPE', EX_OTHER_ERROR);
    	}
    }
	
	//Сохранить файл после конвертации
    function saveConverted($dest_path='') {
		if(!$dest_path)
			$dest_path = D::$content_path . '/#save_path#/#parentid#/' . $this->fileid;
    	$dest_path = $this->replaceToMyMeta($dest_path);
    	//теперь используя объект конкретного класса (картинка, видео или звук)
    	$this->instance->ConvertAndSave($dest_path);
    	return $dest_path;
    }
	
	//Сохранить превью
	function saveThumb($dest_path='') {
		if(!$dest_path)
			$dest_path = D::$content_path . '/#save_path#/thumbs/#parentid#/' . $this->fileid;
		$dest_path = $this->replaceToMyMeta($dest_path);
		//теперь используя объект конкретного класса (картинка, видео или звук)
		$this->instance->saveThumb($dest_path);
		return $dest_path;
	}
	
	function replaceToMyMeta($format = '#time#', $num = 0) {
		//В случае если имя не на ENG делаем транслит
		$filename_translit = preg_replace("/[^A-Za-z0-9_]+/", "_", D_Core_i18n::translit($this->filename));
		return str_replace(array('#size_x#','#size_y#','#size#','#time#','#duration#','#dirnamerus#','#ext#','#parentid#','#fileid#','#filename#','#num#','#save_path#'),
		array($this->instance->size_x,$this->instance->size_y,$this->instance->size,time(),
		      $this->instance->duration, addslashes($this->parentid), $this->instance->ext ,$this->parentid, $this->fileid, $filename_translit, $num,$this->save_path),$format);
	}

    //создаем внутренний объект позволяющий манипулировать медиаданными

    //функция нанесения надписи на изображения, alpha_level от 0(непрозрачное) до 128(полностью прозрачное)
	static function create_watermark( $main_img_obj, $text, $font, $r = 128, $g = 128, $b = 128, $alpha_level = 100 )
  	{
   		$width = imagesx($main_img_obj);
   		$height = imagesy($main_img_obj);
   		$angle =  0;  //угол поворота надписи
   		$text = " ".$text." ";
   		$color = imagecolorallocatealpha($main_img_obj, $r, $g, $b, $alpha_level);
   		$size = (($width+$height)/2)*1/strlen($text);
   		$x = $width - (strlen($text)*($size/2));
   		$y = $height - ($size/2);
   		imagettftext($main_img_obj,$size ,$angle, $x, $y, $color, $font, $text);
   		return $main_img_obj;
  	}

	//функция накладывания изображения на изображение, alpha_level: 100 - непрозрачное, 0 - прозрачное
	static function picture_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 )
	{
		$watermark_width = imagesx($watermark_img_obj);
		$watermark_height = imagesy($watermark_img_obj);
		$dest_x = imagesx($main_img_obj) - $watermark_width - 5;
		$dest_y = imagesy($main_img_obj) - $watermark_height - 5;
		imagecopymerge($main_img_obj, $watermark_img_obj, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $alpha_level);
		return $main_img_obj;
	}

  	//функция обновления количества просмотров
  	function UpdateShowCount() {
  		D::$db->exec("INSERT INTO #PX#_media_files_stat (fileid, `show`) VALUES (md5('".$this->object_id()."'), '1') ON DUPLICATE KEY UPDATE `show` = `show` + 1");
  		return $this;
  	}

  	//функция обновления количества комментариев
  	function UpdateCommentsCount($dirid) {
  		//echo $dirid . "<br>" . $this->fileid; exit;
  		$object_id = substr('media-'.$dirid.'-'.$this->fileid,0,60);
  		$stat = D::$db->fetchvar("SELECT count FROM #PX#_comments_all WHERE object_id = '{$object_id}' LIMIT 1");
  		return $this;
  	//	D::$db->exec("UPDATE #PX#_media_files_stat SET `comments` = '{$stat->count}' WHERE `fileid` = md5('{$this->fileid}') LIMIT 1");
  	}


  	//функция перевода байт в кб-Мб-Гб
  	static function Size2Str($size) {
	    $kb = 1024;
	    $mb = 1024 * $kb;
	    $gb = 1024 * $mb;
	    $tb = 1024 * $gb;
	    if ($size < $kb) {
	        return $size.' байт';
	    } else if ($size < $mb) {
	        return round($size / $kb, 2).' Кб';
	    } else if ($size < $gb) {
	        return round($size / $mb, 2).' Мб';
	    } else if ($size < $tb) {
	        return round($size / $gb, 2).' Гб';
	    } else {
	        return round($size / $tb, 2).' Тб';
	    }
	}

    /**
     * Удаляем файл из базы и из файлохранилища
     */
    function delete($full_delete = true) {
    	D::$db->exec("DELETE FROM #PX#_media_files WHERE parentid = '{$this->parentid}' and fileid = '{$this->fileid}' LIMIT 1");
    	if($full_delete) {
    		unlink(D::$content_path . "/media/thumbs/{$this->parentid}/{$this->fileid}");
    		unlink(D::$content_path . "/media/{$this->parentid}/{$this->fileid}");
            //unlink(D::$content_path . "/media/{$this->parentid}/origin/{$this->fileid}");
    	}
    }

}
?>