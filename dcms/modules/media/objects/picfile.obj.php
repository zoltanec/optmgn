<?php
Class PicFile extends D_Files_Image {
	protected $img = false;
	public $size_x = 0;
	public $size_y = 0;
	public $size = 0;
	public $file_path = '';
	public $duration = 0;
	static protected $extensions = array('jpg', 'png', 'gif');

	function __construct($file_path = '') {
		if(!empty($file_path)) {
			$this->file_path = $file_path;
			parent::__construct($this->file_path);
    		$this->size = filesize($file_path);
    		$extArr = explode('.',basename($file_path));
    		if(in_array(end($extArr), self::$extensions)) {
    			$this->ext = end($extArr);
    		} else {
    			$this->ext = self::$extensions[0];
    		}
		}
	}
	
	function cutImage($width, $height){
		$new = imagecreatetruecolor($this->size_x,$this->size_y-20);
		//копируем из старого в новое
		//imagecopyresampled($new,$this->img,0,0,0,0,$this->size_x,$this->size_y,$this->x,$this->y);
		imagecopy($new, $this->img, 0, 0, 0, 0, $this->size_x, $this->size_y-20);
		//загружаем в созданный объект данные
		$img = new D_Files_Image($this->file_path);
		$img->load($new);
        return $img;
	}

	function ConvertAndSave($dest_path,$cut=false) {
		//Размер берем из конфига img_size
		if(Media_File::$setting->img_size)
			list($size_x,$size_y) = explode('x', Media_File::$setting->img_size);
		else list($size_x,$size_y) = array(800,800);
		//$format
		$this->GetPreview($size_x,$size_y)->save($dest_path);
		//Если save_origin то сохраняем еще и оригинал
		if(Media_File::$setting->save_original) {
      $dest_array = explode('/',$dest_path);
			$filename = end($dest_array);
			$dest_path = preg_replace('#(.*?)(' . $filename . ')#si', '$1/origin/$2', $dest_path);
			$this->save($dest_path);
		}
	}
	
    //создание превью и нанесение водного знака на исходное изображение
    function saveThumb($dest_path) {
		//Размер берем из конфига thumb_size
		if(Media_File::$setting->thumb_size)
			list($size_x,$size_y) = explode('x', Media_File::$setting->thumb_size);
		else list($size_x,$size_y) = array(260,260);
		//$format
    	$this->GetPreview($size_x,$size_y)->save($dest_path);
    }
}
?>