<?php
class Question extends dObject {
	// идентификатор вопроса
	public $qid = 0;
	//непосредственном сам вопрос
	public $question = '';
	//режим вопроса
	public $mode = 0;
	// подсказка на поле ввода дополнительной инфы
	public $input_tip = '';
	// список доступных вариантов
	public $variants = '';

	// получение информации о вопросе
	public static function __fetch() {

	}
}
?>