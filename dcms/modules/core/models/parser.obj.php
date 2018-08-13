<?php
# Parser
# Вспомогательный класс для парсинга информации c других сайтов

Class Core_Parser extends D_Core_Object {
	//3 получить урл ссылки 4 получить картинку и сохранить
 
	static public $url;
    static public $siteUrl;
	static $patterns = array(
			'habrahabr' => array( //utf8 cp1251
				'pagetitle' => '#<h1.*?class="title"><span.*?>(.*?)</span>.*?|</h1>#si',
				'content' => '#<div.*?class="content(\s.*?)">(.*?)<div class="clear">#si'
	    ),
			'ruseller' => array(
				'content' => '#<div.*?id="lessons">.*?</h1>(.*?)<div id="lessonPrepared">#si',
				'pagetitle' => '#<h1.*?>(.*?)</h1>#si'
	    ),
			'ubunta' => array(
				'content' => '#<div.*?class="content">(.*?)<div class="clearer">#si',
				'pagetitle' => '#<h1.*?>(.*?)</h1>#si'
	    ),
			'htmlbook' => array(
				'content' => '#<div.*?class="block_content ">.*?<div class="field-item even">(.*?)</div></div></div><div class="metki">#si',
				'pagetitle' => '#<h1.*?>(.*?)</h1>#si'
	    ),
			'chota' => array(
				'content' => '#<div.*?class="container ">(.*?)</div>#si',
				'pagetitle' => '#<h1.*?>(.*?)</h1>#si'
	    ),
			'metalindex' => array(
			'pagetitle' => '#<h1.*?>(.*?)</h1>#si',
				'content' => '#<div.*?class="center1a".*?>.*?<div.*?>(.*?)</div>#si'
				
	    ),
			'metalbulletin' => array(
				'content' => '#<div.*?class="text1".*?><span>(.*?)</span></div>#si',
				'pagetitle' => '#<div.*?class="one_news_title".*?>(.*?)</div>#si')
		);
		
	// Обход защиты от роботов
	static function avoidRobots($user, $password, $url) {
		//!Проверяем залогинены или нет
		//$test_login = D_Misc_Url::FetchDocument( $url, false, '', '', preg_match('#(http://.*?/)#', $url, $matches) );
		//preg_match('#<p class="header">Вход на сайт<i>#si', $test_login, $matches);
		
		//Если мы не залогинены и находимся на странице Вход на сайт
        //if(count($matches)){
			//$search_text = preg_match('#http://(.*?)/#', $url, $matches);
			//D_Misc_Url::FetchDocument(
			//  'http://yandex.ru/yandsearch?text=&lr=235',
			//  false, '', ''//, // POST и кодировки здесь не нужны ...
            //);
            //D_Misc_Url::FetchDocument(
            //  'http://www.kinopoisk.ru/index.php?kp_query=мушкетеры&x=0&y=0',
            //  false, '', '', // ... и здесь тоже ...
            //  'http://www.kinopoisk.ru/'
            //);
		//}	
			
		//Авторизуемся в системе
		$robot = D_Misc_Url::FetchDocument(
			$url,
			array(
                'name' => $user,
				'password' => $password
			),
			'',
            '',
			'http://ruseller.com'
		);
	}
	
	static function getDocument($url, $referer, $i_enc='', $o_enc='' , $sleep = 2){
		preg_match('#http://.*?\?(.*?)/#', $url, $matches);
		return D_Misc_Url::FetchDocument( $url, false, $i_enc, $o_enc, $referer); 
	}

    // Записывает в базу данные (по указанной ссылке [url])
    static function parseByUrl( $url, $object, $pattern = array(), $source_link=false, $robots = false ){
        if(!preg_match('#http://.*#',$url))
            $url = 'http://' . $url;
            preg_match('#(http://.*?)/.*#',$url,$siteUrl);
            self::$siteUrl = end($siteUrl);
        // Обходим робото-защиту
        if( $robots !== false )
            self::avoidRobots($user, $password, $auth_url);

        //На сайте http://ruseller.com/ не открывается без этого страница
        //$url .= '&';
        //if(!preg_match('/\/$/', $url)) $url .= '/'; // Проверка закрывающего слеша
        $response = [];
        $document = self::getDocument($url,'','cp1251','utf8');

        // Удаляем символы переноса строк и обрабатываем ответ
        $document  = preg_replace("/\r*\n|\s\s+/",'',$document);

        //Если объекта нет, то исключение
        if(!$document)
            var_dump('Error parse document!');
        foreach( $pattern as $property => $preg ) {
            //Ищем совпадения
            preg_match( $preg, $document, $matches );
            //Инициализируем поле
            if($matches) {
                $response[$property] = end($matches);
                if($property == 'imagesContent') {
                    continue;
                }
                $object->{$property} = addslashes(end($matches));
            
                if ($property == 'content') {
                    if($source_link)
                        $object->content .= "<p class=\"link_src\">Источник: <a href=\"" . D::$web 
                                        . "/core/redirect/" 
                                        . base64_encode($url) 
                                        . "\" title=\"{$object->title}\">" 
                                        . preg_replace('#(http://|)([A-Za-z-.]+)/.*#', '$2', $url)
                                        . "</a></p>";
                    $object->content = preg_replace_callback('#(href=")(.*?)(".*?>)#si', 'self::getOutLink', $object->content);
                }
            }
        }
        //var_dump($object);exit;
        $object->save();

        return $response;
    }
  
  static function getOutLink($matches){
		return $matches[1] . D::$web . '/core/redirect/' . base64_encode($matches[2]) . $matches[3];
  }

  /// Получаем ссылки из поиска
  static function parseByName( $name, $cinema=false){
    self::$url = self::findUrl( $name, $engine );
    self::parseByUrl( self::$url );
	return false;
  }

  static function mb_rawurlencode( $url ) {
    $encoded = '';
    $length  = mb_strlen( $url );
    for( $i = 0; $i < $length; $i++ ) {
        $encoded .= '%' . wordwrap( bin2hex( mb_substr( $url, $i, 1 ) ), 2, '%', true );
    }
    return $encoded;
  }

    // Загружает картинки и заменяет src картинок в исходном документе
	static function parseImage( $document, $fileid, $object_id, $module = 'pages', $object = 'icon'){
		//Находим url картинок
		preg_match_all( '#<img[^>]*?src="(.*?)".*?>#is', $document, $matches, PREG_PATTERN_ORDER );
		$images = $matches[1];
		$replace_images = array();
		foreach($images as $index => $img_src){
			//Сохранить в медиатеку
			$img_path = self::saveImageMedia($img_src, $fileid . $index, $object_id, $module);
			$replace_images[] = preg_replace('#.*?(/content)#si', D::$web.'$1', $img_path);
		}
		$document = str_replace($images, $replace_images, $document);
		return $document;
	}
  
    static function saveImageMedia($img_src, $fileId, $object_id, $module = 'pages', $object = 'icon', $mainimg = false){
		D::appendModuleNameSpace('media');
		//Сохраняем временно исходную картинку, потом удаляем
		$filename = D::$config->content_dir.'/'.preg_replace('#.*/.*?(.{6}\.)#','$1',$img_src);
        if(!preg_match('#http.*#', $img_src, $match)) {
            $img_src = self::$siteUrl . $img_src;
        }
		$fp = fopen($filename, 'w'); 
		fwrite($fp, file_get_contents($img_src)); 
		fclose($fp);
		//Добавляем, ужимаем временную картинку в медиатеку
		//Объект дирректория фильма
		Core_SettingValue::$module = $module;
        Core_SettingValue::$object = $object;
		//Медиафайл
		$MediaFile = new Media_File();
		
		//Инициализируем свойства объекта медиафайл
		$MediaFile->parentid($object_id);
		$MediaFile->from($filename);
        $MediaFile->fileid = $MediaFile->replaceToMyMeta($fileId . '.#ext#');
		//var_dump($MediaFile);exit;
		//Сохраняем крупное изображение
		$img_saved = $MediaFile->saveConverted();
		//Сохраняем превью
		//$MediaFile->saveThumb();
		if($mainimg) $MediaFile->priority = 1;
		//$MediaFile->save();
		unlink($filename);
		return $img_saved;
	}
}
?>