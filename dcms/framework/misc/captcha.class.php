<?php
//! Класс герерации капчи
class D_Misc_Captcha extends D_Files_Image {
	//!Ресурс изображения
	protected $img = false;
	//!Код для генерации
	protected $code = false;
	//!Ширина капчи
	protected $width = 80;
	//!Высота капчи
	protected $height = 20;

	//!Генерация кода к изображению
	/**
	 *
	 * @param unknown_type $algo - что за параметр неясно!!!!
	 */
	function generateCode($algo = 'default', $size = 4) {
		switch($algo) {
			case 'numeric':
				$letters = range(0,9);
				$code = array();
				for($x = 0; $x < $size; $x++) {
					$code[] = $letters[rand(0,sizeof($letters)-1)];
				}
				$this->code = implode("",$code);
				break;
			case 'default':
				$this->code = substr(md5(print_r($_SERVER,true)),0, $size);
				break;
		}
		return $this->code;
	}

	/**
	 * Get captchat code
	 */
	function getCode() {
		return $this->code;
	}
	//!Установка кода к изображению вручную
	/**
	 *
	 * @param string $code - код изображения
	 */
	function setCode($code) {
		$this->code = $code;
		return $this;
	}
	//!Получение ширины капчи
	/**
	 *
	 * @return int $width - ширина капчи в px
	 */
	function getWidth() {
		return $this->with;
	}
	//!Получение высоты капчи
	/**
	 *
	 * @return int $height - высота капчи в px
	 */
	function getHeight() {
		return $this->height;
	}
	//!Уставка ширины капчи
	/**
	 *
	 * @param int $width - ширина капчи в px
	 */
	function setWidth($width = 0) {
		$this->width = $width;
	}
	//!Уставка высоты капчи
	/**
	 * @param int $height - высота капчи в px
	 */
	function setHeight($height = 0) {
		$this->height = $height;
	}
	//!Отрисовка изображения капчи
    function &render2() {
        //создаем новую картинку
        $this->img = imagecreate(80, 20);
        //указываем цвета
        imagecolorallocate($this->img, 255, 255, 255);
        $textcolor = imagecolorallocate($this->img, 0, 0, 0);
        imagestring($this->img, 5, 8, 0, $this->code, $textcolor);
        return $this;
    }


    function &render() {
    	$width = 100;				//Ширина изображения
    	$height = 45;				//Высота изображения
    	$font_size = 16;   			//Размер шрифта
    	$let_amount = 4;			//Количество символов, которые нужно набрать
    	$fon_let_amount = 30;		//Количество символов на фоне
    	$font = D::$path."/luximr.ttf";	//Путь к шрифту

	    //набор символов
	    $letters = array("1","2","3","4","5","6","7","8","9");
    	//цвета
    	$colors = array("90","110","130","150","170","190","210");

	    $src = imagecreatetruecolor($width,$height);	//создаем изображение
	    $fon = imagecolorallocate($src,255,255,255);	//создаем фон
   		imagefill($src,0,0,$fon);						//заливаем изображение фоном

    	for($i=0;$i < $fon_let_amount;$i++)			//добавляем на фон буковки
   		{
    		//случайный цвет
    		$color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),100);
    		//случайный символ
    		$letter = $letters[rand(0,sizeof($letters)-1)];
    		//случайный размер
    		$size = rand($font_size-2,$font_size+2);
    		imagettftext($src,$size,rand(0,45),
    		rand($width*0.1,$width-$width*0.1),
    		rand($height*0.2,$height),$color,$font,$letter);
    	}

   		for($i=0; $i < strlen($this->code); $i++)		//то же самое для основных букв
    	{
	    	$color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],
    		$colors[rand(0,sizeof($colors)-1)],
    		$colors[rand(0,sizeof($colors)-1)],rand(20,40));
    		$letter = $this->code[$i];
    		$size = rand($font_size*2-2,$font_size*2+2);
    		$x = ($i+1)*$font_size + rand(1,5);		//даем каждому символу случайное смещение
    		$y = (($height*2)/3) + rand(0,5);
    		imagettftext($src,$size,rand(0,15), $x, $y, $color, $font, $letter);
    	}
    	$this->img = $src;
    	return $this;
    }
}
?>