<?php
//!Класс загрузки файлов
class D_Core_UploadedFiles {
	//!внутренний контейнер загруженных файлов
	public $files = array();

	//!Обрабатываем все поступившие к нам файлы
	/**
	 * Проверяется сколько файлов в массиве $_FILES.\n
	 * Если несколько файлов, обходится массив $_FILES[].\n
	 * Если нет ошибки загрузки,
	 * создается объект dUploadedFile
	 * по каждому загружаемому файлу
	 */
	function __construct() {

		foreach($_FILES AS $key=>$uploaded_file) {
			//если у нас еще один уровень вложенности
			if(is_array($_FILES[$key]['name'])) {
				//похоже вложенность есть
				$this->files[$key] = array();
				//заполняем
				foreach($_FILES[$key]['name'] AS $num=>$value) {
					if(!is_array($_FILES[$key]['name'][$num])) {
						//создаем новый файл
						if($_FILES[$key]['error'][$num] == UPLOAD_ERR_OK) {
							$this->files[$key][] = new D_Core_UploadedFile($_FILES[$key]['type'][$num], $_FILES[$key]['tmp_name'][$num],
																	 $_FILES[$key]['size'][$num], $_FILES[$key]['name'][$num]);
						}
					}
				}
			} else {
				if($_FILES[$key]['error'] == UPLOAD_ERR_OK) {
					$this->files[$key] = new D_Core_UploadedFile($_FILES[$key]['type'], $_FILES[$key]['tmp_name'],
														   $_FILES[$key]['size'], $_FILES[$key]['name']);
				}
			}
		}
	}
}
?>