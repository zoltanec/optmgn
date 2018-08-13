<?php
Class AudioFile extends Media_File {

	public $duration = 0;
	public $size_x = 0;
	public $size_y = 0;
	public $size = 0;

	function __construct($filename = '') {
		if(!empty($filename)) {
			$movie = new ffmpeg_movie($filename);
  			$this->duration = $movie->getDuration();
    		$this->size = filesize($filename);
    		$file = new Media_File($filename);
    		$this->dirnamerus = $file->parent()->dirname;
		}
	}

	function save($filename, $fileid, $dirid) {
        D::$db->exec("INSERT INTO #PREFIX#_media_files (fileid,parentid,filename,type) VALUES ('{$fileid}','{$dirid}','{$filename}','audio') ON
        DUPLICATE KEY UPDATE parentid = '{$dirid}'");
    }

    function getPreview($audio, $fileid, $dirid) {
    	$file = new ffmpeg_movie($audio);
    	$len = $file->getDuration();
    	$len = date('i:s' , $len);
    	copy(D::$content_path."/media/thumbs/audio.jpg", D::$content_path."/media/thumbs/".$dirid."/".basename($audio).".jpg");
		$img = imagecreatefromjpeg(D::$content_path."/media/thumbs/".$dirid."/".basename($audio).".jpg");
		$im = parent::create_watermark($img, $len, D::$content_path."/font.ttf", 0, 0, 0, 0);
		imagejpeg($im,D::$content_path."/media/thumbs/".$dirid."/".basename($audio).".jpg");
    }
}
?>