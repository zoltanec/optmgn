<?php
//класс для работы с изображениями
class D_Files_Image {
    //дескриптор изображения
    protected $img = false;
    protected $hash = '';
    public $size_x = 0;
    public $size_y = 0;
    //конструктор класса
    function __construct($input = 0) {
      //если вообще что то подали в качестве входа
      if($input) {
        //проверяем что у нас на входе
        if(is_object($input)) {
          if(get_class($input) == 'D_Core_UploadedFile') {
              //загружаем файл из картинки что нам передали
              $filename = $input->tmp_name;
          }
        } elseif (is_string($input)) {
          $filename = $input;
        }
        $name = explode('.',$filename);
        $ext = strtolower(end($name));
        switch($ext) {
          case 'png'  : $this->img = imagecreatefrompng($filename); break;
          case 'jpg'  : $this->img = imagecreatefromjpeg($filename); break;
          case 'jpeg' : $this->img = imagecreatefromjpeg($filename); break;
          case 'gif'  : $this->img = imagecreatefromgif($filename); break;
          default: $this->img = imagecreatefromstring(file_get_contents($filename)); break;
        }
        //вычисляем размеры
        $this->size_x = imagesx($this->img);
        $this->size_y = imagesy($this->img);
      }
    }

    //принятие изображения
    function load($imgres) {
      //delete old img
      unset($this->img);
      $this->img = $imgres;
      $this->size_x = imagesx($this->img);
      $this->size_y = imagesy($this->img);
    }

    //сохраняем наш файлег
    function save($path_in, $format = 'jpg', $createdir = true) {
      if(!$this->img) {
        return false;
      }
      //заменяем спец строки ( макросы )
      $path = str_replace(array('%X%','%Y%','%EXT%'),array($this->size_x,$this->size_y,$format),$path_in);
      //если указан флаг создания каталога
      if($createdir) {
        if(!is_dir(dirname($path))) {
          //создаем рекурсивно каталог
          mkdir(dirname($path),0775,true);
        }
      }

      // if this file exists but not available for writing or directory not available for writing
      if( (is_file($path) && !is_writeable($path)) || !is_writeable(dirname($path))) throw new D_Exceptions_WriteDenied("Write to {$path} denied.");
      //imageinterlace($destination_resource, 1); Прогрессивный jpeg
      switch($format) {
        case "png": return imagepng($this->img,$path);break;
        case "jpg": return imagejpeg($this->img,$path, 100);break;
        case "jpeg": return imagejpeg($this->img,$path, 100);break;
        case "gif": return imagegif($this->img,$path);break;
      }
    }

    /**
     * Возвращаем объект изображения как картинку через буфер вывода в браузер
     */
    function asString($format = 'png') {
      //кэшируем вывод скрипта
      ob_start();

      switch ($format) {
        case 'png' : imagepng($this->img); break;
        case 'jpg' : $white = imagecolorallocate($this->img,255,255,255); ImageFilledRectangle($pic,0,0,100,100,$col2); imagejpeg($this->img); break;
        case 'gif' : imagegif($this->img); break;
      }
      $ImageContent = ob_get_contents();
      ob_end_clean();
      return $ImageContent;
    }

    /**
     * Sohranyaem kartinku v neskolkih mestah s razlichnimi razresheniyami
     * @param array $savepath
     */
    function saveMultiple($savepath = array()) {
      //obrabativaem puti sohraneniya
      foreach($savepath AS $path) {
        //if(is_string())
      }
    }

    /**
     * Get image orientation
     * @return string $orientation - album or portrait
     */
    function getOrientation() {
      return ( $this->size_x > $this->size_y ) ? 'album' : 'portrait';
    }

    //сохранить файл с измененными размерами, указывается максимальная высота или ширина..или все и сразу
    function getPreview($width = 0, $height = 0, $resize_func = 'resize') {
      $img = clone $this;
      //var_dump($resize_func);exit;
      $img->{$resize_func}($width,$height);
      return $img;
    }

    /**
     * Вырезка из изображения прямоугольника с заданными размерами
     *
     * @param int $width - ширина
     * @param int $height - высота
     */

    function scale($width = 0, $height = 0) {
      $new_width = $this->size_x;
      $new_height = $this->size_y;
      if($width != 0){
        $new_width = $width;
      }
      if($height != 0){
        $new_height = $height;
      }
      //var_dump($this->size_x);exit;
      if($this->size_x > $new_width || $this->size_y > $new_height) {
        //создаем новое изображение
        $new = imagecreatetruecolor($new_width,$new_height);
        $new_width_st1 = ($this->size_x - $new_width)/2;
        $new_height_st1 = ($this->size_y - $new_height)/2;
        //var_dump($new_width_st1);exit;
        $white = imagecolorallocate($new,255,255,255);
        ImageFilledRectangle($new,0,0,$new_width,$new_height,$white);

        //imagecolortransparent($new,$white);
        //imagecopyresampled($new,$this->img,0,0,0,0,$new_width_st1,$new_height_st1,$this->size_x,$this->size_y);
              //копируем из старого в новое

        //$new = imagecreatetruecolor($new_width, $new_height);
        /**
        Перед тем как произодить опрерации с новым ресурсом,
        установим некоторые опции
        imageAlphaBlending - устанавливает режим смешивания(режим
        смешивания недоступен для изображений с палитрой)
        по умолчанию для truecolor изображений - true, для изображений
        с палитрой - false
        true/false - включен/выключен

            true - при накладывании одного изображения на другое
            цвета пикселей нижележащего и накладываемого изображения смешиваются,
            параметры смешивания определяются прозрачностью пикселя.

            false - накладываемый пиксель заменяет исходный
        */
        //imageAlphaBlending($new, false);
        /*
        ImageSaveAlpha
        Сохранять или не сохранять информацию о прозрачности
        по умолчанию - false, а надо true
        */
        //imageSaveAlpha($new, true);
        imagecopyresampled($new,$this->img,0,0,0,0,$new_width,$new_height,$this->size_x,$this->size_y);
        //загружаем в созданный объект данные
        $this->load($new);
      }
      //возвращаем результат
      return $this;
    }

    /**
     * Вырезка изображения и вставка его в прямоугольник с заданным размером
     * При вырезке выбирается середина изображения соответсвующая пропорции картинки назначения
     *
     * @param int $width - ширина
     * @param int $height - высота
     */
    public function crop($width = 0, $height = 0, $color = 'NONE' ) {
    	//$height = $width;
    	// нам необходимо найти размеры четырехугольника с теми же пропорциями что у конечного изображения,
    	// но который будет вписан в исходное изображение
      $x_y = $height/$width;
      //echo $x_y;
      //выбираем базовую ширину
      $base_width = $this->size_x;
      if($this->size_y < $base_width * $x_y) {
        $base_width = $this->size_y / $x_y;
      }
      $cut_width = $base_width;
      $cut_height = $cut_width * $x_y;
      //echo $cut_width."<br>";
      //echo $cut_height."<br>";
      //пусть пока у нас только будут нарезка квадратов
      //определяем режим изображения, альбомное или портретное
      $src_x = $src_y = $width;
      if($this->getOrientation() != 'album') {
        $src_x = 0;
        $src_y = ( $this->size_y - $cut_height ) / 2 ;
      } else {
        $src_x = ( $this->size_x - $cut_width ) / 2 ;
        $src_y = 0;
      }
      //новый квадрат изображения
      $new = imagecreatetruecolor($width, $height);
      imagecopyresampled($new, $this->img, 0, 0, $src_x, $src_y, $width, $height, $cut_width, $cut_height);
      $this->load($new);
      //определяем каким оно должно стать в итоге
      //масштабируем вырезку до размера самого изображения
      //определяем откуда и до куда мы должны резать
      //вырезаем изображения и вставляем в новое
      return $this;
    }

    /**
     * Resize izobrageniya
     * @param int width - shirina izobrageniya;
     * @param int height - visota izobrageniya.
     */
    function resize($width = 0, $height = 0) {
        //вычисляем соотношение сторон
        $ratio = $this->size_x/$this->size_y;
        //чтоб были уже установленные данные
        $new_width = $this->size_x;
        $new_height = $this->size_y;
        //если указана максимальная ширина картинки
        if($width != 0 && $this->size_x > $width ) {
            //вычисляем новые размеры. ширину и высоту
            $new_width = $width;
            $new_height = $width / $ratio;
            //если указан размер вписывания по высоте
            if($height != 0 AND $new_height > $height) {
                $new_height = $height;
                $new_width = $new_height * $ratio;
            }
        //если вписывать нам картинку надо по высоте
        } elseif ($height != 0 && $this->size_y > $height) {
            $new_height = $height;
            $new_width = $height * $ratio;
            //если новая ширина не катит, ибо большая
            if($width != 0 AND $new_width > $width) {
                $new_width = $width;
                $new_height = $width / $ratio;
            }
        }
        //esli izmenilis' parametri izobrageniya
        if($this->size_x != $new_width or $this->size_y != $new_height) {
			//создаем новое изображение
			$new = imagecreatetruecolor($new_width, $new_height);
				/**
				Перед тем как произодить опрерации с новым ресурсом,
				установим некоторые опции
				imageAlphaBlending - устанавливает режим смешивания(режим
				смешивания недоступен для изображений с палитрой)
				по умолчанию для truecolor изображений - true, для изображений
				с палитрой - false
				true/false - включен/выключен

						true - при накладывании одного изображения на другое
						цвета пикселей нижележащего и накладываемого изображения смешиваются,
						параметры смешивания определяются прозрачностью пикселя.

						false - накладываемый пиксель заменяет исходный
				*/
				imageAlphaBlending($new, false);
				/*
				ImageSaveAlpha
				Сохранять или не сохранять информацию о прозрачности
				по умолчанию - false, а надо true
				*/
				imageSaveAlpha($new, true);
			//копируем из старого в новое
			imagecopyresampled($new,$this->img,0,0,0,0,$new_width,$new_height,$this->size_x,$this->size_y);
			//загружаем в созданный объект данные
			$this->load($new);
        }
        //возвращаем результат
        return $this;
    }

    function setWaterText($text, $options = array()) {
        $width_to_height_font_coef = (isset($options[';'])) ? $options['width_to_height_font_coef'] : 1;
        $font_file = (isset($options['font_file'])) ? $options['font_file'] : '/usr/share/fonts/corefonts/verdanab.ttf';
        // размер шрифта
        $font_size = (isset($options['font_size'])) ? $options['font_size'] : 40;
        // размещение картинки
        $position = (isset($options['position'])) ? $options['position'] : 'center-center';
                if(!in_array($position, array('left-top','left-middle','left-bottom','center-top','center-middle','center-bottom','right-top','right-middle','right-bottom'))) {
                        $position = 'center-center';
                }
                list($position_left, $position_top) = explode('-', $position);

        $color = imagecolorallocatealpha($this->img,255,255,255,70);
        // сначала высчитываем ожидаемую длину сообщения
        $text_width = strlen($text) * ( $font_size / $width_to_height_font_coef );
        if($position_left == 'right') {
                $margin_left = $this->size_x - $text_width + 2;
        } else {
                $margin_left = ( $this->size_x - $text_width ) / 2 ;
        }
        if($position_top == 'bottom') {
                $margin_top = $this->size_y - 3;
        } else {
                $margin_top = $font_size / 2 + ($this->size_y - $font_size ) / 2 ;
        }
        imagettftext($this->img, $font_size ,0, $margin_left, $margin_top , $color, $font_file, $text);
    }

    //отображение картинки
    function show() {
        header("Content-type: image/png");
        imagepng($this->img);
    }
}
?>