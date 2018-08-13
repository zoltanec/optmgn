<?php
class File {
	//Время полного кеширования объекта
	static protected $cacheself = 0;
	//имя файла
	public $filename = '';
	public $filepath = '';
	//Путь к файлу от корня сайта
	public $url = '';
	//тип файла
	public $ext = '';
	//размер
	public $filesize = 0;
	//владелец
	public $owner;
	//права
	public $perms;
	//путь от корня
	public $pwd;
	//тип дирректория|файл
	public $filetype;
	public $updatetime;
	public $parent_pwd = '';

	function __construct($path){
		// путь к файлу
		$this->pwd = preg_replace('/\/$/', '', $path);
		$this->parent_pwd = substr($path, 0, strripos($path, "/"));
		// имя файла
		$this->filename=end(explode('/',$this->pwd));
		$this->filepath=str_replace($this->filename, '', $path);
		$this->url=D::$web.str_replace(D::$path,'',$this->pwd);
		// размер файла в байтах
		$this->filesize = filesize($this->pwd);
		// тип файла, каталог, файл, пайп и тд
		$this->filetype=filetype($this->pwd);
		if ($this->filetype=="file")
		$this->ext=end(explode('.',$this->filename));
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
		if (strcmp($this->pwd,D::$config->content_path)<1) {
			$this->pwd=D::$config->content_path;
		}
		if ($this->filetype=='dir') {
		$dir=opendir($this->pwd);
		$num=0;
		$result=array();
		while(false!==($filename=readdir($dir))){
			if($filename=='.')
			continue;
			if($filename=='..' && $this->pwd==D::$config->content_path)
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
	
	function get_tree()	{
		if($this->filetype=='dir') {
			$html .= '<li><span class="folder">'."\n";
			$html .= '<a class="lsfiles" href="list/dir_'.$this->getPwd64().'">'.$this->filename."</a></span>\n";
			$dir=opendir($this->pwd);
			$html .= '<ul> '."\n";
			while(false!==($filename=readdir($dir))) {
			    if($filename=='.' || $filename=='..') continue;
			    $file=new self($this->pwd.'/'.$filename);
			    $html.=$file->get_tree();
			}
			$html .= '</ul>' . "\n";
			$html .= '</li>'."\n";
		    closedir($dir);
		} 
		return $html;
	}
}
?>