<?php
trait D_Files_Icon {
  //Определить модуль по классу
  static function __module() {
    return preg_replace('#(.*?)_.*#', '$1', strtolower(get_class($this)));
  }
  //Название дирректории с иконками
  static function __icon_dirname() {
		return preg_replace('#.*_(.*?)#', '$1', strtolower(get_called_class()));
	}
  
  protected function __icon_title() {
		return $this->title;
	}
  
  protected function __alias() {
		return $this->alias;
	}
  
  public function icon_exists() {
    return file_exists($this->__icon_dir() . $this->__alias() . '.jpg');
  }
  //TODO сделать иконку по умолчанию, если текущая отсутствует по размеру
  //Получить иконку
  public function __icon() {
    return '<img title="'
                 . $this->__icon_title() . '" alt="'
                 . $this->__icon_title() . '" src="'
                 . D::$config->content_path . '/images/'  
                 . self::__module() . '/'
                 . self::__icon_dirname() . '/'
                 . $this->__alias()
                 . '.jpg" />';
  }
  
  //Получить превью иконки
  public function __thumbs() {
    return '<img title="'
                 . $this->__icon_title() . '" alt="'
                 . $this->__icon_title() . '" src="'
                 . D::$config->content_path . '/images/'  
                 . self::__module() . '/thumbs/'
                 . self::__icon_dirname() . '/'
                 . $this->__alias()
                 . '.jpg" />';
  }
  
  //Получить путь к превью иконки
  public function __thumbs_url() {
    return D::$config->content_path . '/images/'
         . self::__module() . '/thumbs/'
         . self::__icon_dirname() . '/'
         . $this->__alias()
         . '.jpg';
  }
 
  public function __thumbs_slider_url() {
    return D::$config->content_path . '/images/'
         . self::__module() . '/thumbs/'
         . $this->__slider_dirname() . '/';
  }
  
  public function __sliders() {
    $sliderPath = D::$config->content_dir . '/images/'
         . self::__module()
         . $this->__slider_dirname() . '/'
         . $this->__alias();
    $sliderUrl = D::$config->content_path . '/images/'
         . self::__module() . '/'
         . $this->__slider_dirname() . '/'
         . $this->__alias();
    $index = 0;
    $sliders = [];
    while(file_exists($sliderPath . $index . '.jpg')) {
        $sliders[] = $sliderUrl . $index . '.jpg';
        $index++;
    }
    return $sliders;
  }
  
  public function __thumbs_sliders() {
    $sliderPath = D::$config->content_dir . '/images/'
         . self::__module() . '/thumbs/'
         . $this->__slider_dirname() . '/'
         . $this->__alias();
    $sliderUrl = D::$config->content_path . '/images/'
         . self::__module() . '/thumbs/'
         . $this->__slider_dirname() . '/'
         . $this->__alias();
    $index = 0;
    $sliders = [];
    while(file_exists($sliderPath . $index . '.jpg')) {
        $sliders[] = $sliderUrl . $index . '.jpg';
        $index++;
    }
    return $sliders;
  }
  
  //Получить путь к иконке
  public function __icon_url() {
    return D::$config->content_path . '/images/'
         . self::__module() . '/'
         . self::__icon_dirname() . '/'
         . $this->__alias()
         . '.jpg';
  }
  
  public function __icon_dir() {
    return D::$config->content_path . '/images/' 
         . self::__module() . '/'
         . self::__icon_dirname() . '/';
  }
  
  public function __thumbs_dir() {
    return D::$config->content_path . '/images/' 
         . self::__module() . '/thumbs/'
         . self::__icon_dirname() . '/';
  }
  
  //Проверка смены псевдонима и переименование иконки
  public function checkOutAlias() {
    if($this->aliasChanged)
      $this->renameIcon();
  }
  
  //Переименование иконки
  public function renameIcon() {
    if(file_exists($this->__icon_dir() . $this->aliasChanged))
      rename($this->__icon_dir() . $this->aliasChanged, $this->__icon_dir() . $this->__alias());
      rename($this->__thumbs_dir() . $this->aliasChanged, $this->__thumbs_dir() . $this->__alias());
  }
  
  //Удаление иконки
  public function deleteIcon() {
    unlink($this->__icon_dir() . $this->__alias());
    unlink($this->__thumbs_dir() . $this->__alias());
  }
}
?>