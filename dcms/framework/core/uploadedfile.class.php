<?php
//!класс для работы с загружаемыми файлами
class D_Core_UploadedFile {
	//!размер файла
	var $size = 0;
	//!тип файла
	var $type = 'text/html';
	//!имя файла
	var $tmp_name;

	//!Создаем объект загружаемого файла
	/**
	 *
	 * @param $type - тип файла
	 * @param $tmp_name - временное имя файла
	 * @param $size - размер файла
	 * @param $name - имя файла
	 */
	function __construct($type,$tmp_name,$size, $name = '') {
		$this->size = $size;
		$this->type = $type;
		$this->tmp_name = $tmp_name;
		$this->name = $name;
	}
	//!Получение расширения оригинального файла
	function getExt() {
		$splittedName = explode('.',strtolower($this->name));
		return end($splittedName);
	}
	//!Получение временного имени файла
	function __toString() {
		return $this->tmp_name;
	}

	//!Сохранение файла с новым именем
	function SaveAs($newpath) {
		if(!move_uploaded_file($this->tmp_name, $newpath)) {
			return false;
		} else {
			return true;
		}
	}
}
?>