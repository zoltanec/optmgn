<?php
Class VideoFile {

	public $duration = 0;
	public $size_x = 0;
	public $size_y = 0;
	public $size = 0;
	public $filename = '';
	public $ext = 'flv';

	function __construct($filename) {
		if(!empty($filename)) {
			$this->filename = $filename;
			$this->movie = new ffmpeg_movie($filename);
			if($this->movie) {
				$this->size_x = $this->movie->getFrameWidth();
  				$this->size_y = $this->movie->getFrameHeight();
  				$this->duration = $this->movie->getDuration();
    			$this->size = filesize($filename);
    			$name = explode('.',$filename);
    			$this->ext = end($name);
			}
		}
	}

    //Конвертируем видео-файл
    //требуются пакеты "ffmpeg"
    protected function ConvertToFlv($input, $output) {
    	D::$db->exec("INSERT INTO #PX#_media_files_convert (input, output, type) VALUES ('{$input}','{$output}','flv')");
    	return true;
    	//итак, сначала мы открываем поток и пишем туда данные о файла
		//passthru("(ffmpeg -i " . escapeshellarg($input) . " -f flv -s 320x240 -y -ar 44100 " . escapeshellarg($output) . " && rm ".$input." & )>> /dev/null 2>&1");
    }

    function ConvertAndSave($dest_path) {
    	if($this->ext != 'flv') {
    		$this->ConvertToFlv($this->filename, $dest_path);
    	} else {
    		if(!copy($this->filename, $dest_path)) {
    			return false;
    		} else {
    			return true;
    		}
    	}

    }

    //получаем превью видео-файла. Требуется пакет "php5-ffmpeg"
    //и наносим на превью время проигрывания файла
    function GetPreview() {
    	$tmpPath = '/tmp/mplayer/'.md5(rand().rand());
    	$frameName = $tmpPath.'/00000001.jpg';
    	$output = system("mplayer '{$this->filename}' -nosound -vo jpeg:outdir={$tmpPath}  -frames 1 -ss 2 > /dev/null", $result);
    	if(file_exists($frameName)) {
    		$preview = new dImageFile($frameName);
    		@unlink($frameName);
    		@rmdir($tmpPath);
    		return $preview;
    	} else {
    		echo "unable to create preview";
    		return new dImageFile();
    	}
    }
}
?>