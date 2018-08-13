<?php
class File {
	//Время полного кеширования объекта
	static protected $cacheself = 0;
	//имя файла
	public $filename = '';
	public $filepath = '';
	//размер
	public $filesize = 0;
	//владелец
	public $owner;
	//права
	public $perms;
	//тип
	public $pwd;
	public $filetype;
	public $updatetime;
	public $parent_pwd = '';

	function __construct($path){
		// путь к файлу
		$this->pwd = preg_replace('/\/$/', '', $path);
		$this->parent_pwd = substr($path, 0, strripos($path, "/"));
		// имя файла
		$tmparr = explode('/',$this->pwd);	//little patch for hide "Strict" messages
		$this->filename=end($tmparr);
		$this->filepath=str_replace($this->filename, '', $path);
		// размер файла в байтах
		$this->filesize = filesize($this->pwd);
		// тип файла, каталог, файл, пайп и тд
		$this->filetype=filetype($this->pwd);
		// время последнего изменения
		$this->upd_time=filemtime($this->pwd);
		// владельцы файла, пользователь, группа
		$this->owner = posix_getpwuid(fileowner($this->pwd));
		$this->group = posix_getgrgid(filegroup($this->pwd));

		$this->perms = substr(sprintf('%o', fileperms($this->pwd)),-4);
	}

	function getPwd64() {
		return base64_encode(urlencode($this->pwd));
	}
	function getParentPwd64() {
		return base64_encode(urlencode($this->parent_pwd));
	}
	function lsdir() {
		if (strcmp($this->pwd,D::$config->content_dir)<1) {
			$this->pwd=D::$config->content_dir;
		}
		if ($this->filetype=='dir') {
		$dir=opendir($this->pwd);
		$num=0;
		$result=array();
		while(false!==($filename=readdir($dir))){
			if($filename=='.')
			continue;
			if($filename=='..' && $this->pwd==D::$config->content_dir)
			continue;
			$result[$num]=new self($this->pwd.'/'.$filename);
			$num++;
		}
		sort($result);
		return $result;
		}
	}

	function delete() {
		if($this->filetype=='dir') {
			//rmdir($this->pwd);
			 $dir=opendir($this->pwd); // открываем директорию
		// запускаем цикл который будет "обходить содержимое заданной директории и удалять все подряд"
        while(false!==($filename=readdir($dir))) {
                if($filename=='.' || $filename=='..') continue; // естесственно, если нам попадается "путь на уровень выше" "." или "..", то пропускаем такой "файл" :)
                $file=new self($this->pwd.'/'.$filename);
                $file->delete(); // все остальное удаляем
        }
        closedir($dir);
        rmdir($this->pwd);
		} else {
			unlink($this->pwd);
		}
	}

}
?>
