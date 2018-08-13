<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
error_reporting(0);
// Внедрение PEAR::Spreadsheet_Excel_Writer
require_once "Spreadsheet/Excel/Writer.php";
// Создание случая, отправка имени файла для создания
$xls = new Spreadsheet_Excel_Writer();
// send xls data
$xls->send("poll_export.xls");
// version
$xls->setVersion(8);
//Добавление листа к файлу, возвращение объекта для добавления данныx
$sheet =& $xls->addWorksheet('Binary Count');
$sheet->setInputEncoding('utf-8');
// получаем наши результаты
// а пошли поехали
$last_catid = 0;
$row = 0;
$format_title =$xls->addFormat();
$format_title->setBold();

foreach($poll->active_questions AS $question) {
	if( $question->catid != $last_catid ) {
		$row += 2;
		$sheet->setMerge($row, 0, $row, 10);
		$sheet->write($row, 0, 'Категория:'.$poll->getCategoryName($question->catid), $format_title );
		$row++;
	}
	$sheet->write($row, 0, $question->question);
	$cell = 1;
	foreach($question->getAnswers() AS $num => $answer) {
		$sheet->write($row, $cell, 'Код:'.$num);
		$sheet->write($row, $cell + 1, 'Ответ:'.trim($answer));
		$cell += 2;
	}
	$row++;
}
/**



$list = Polls_Useranswer::getResultsList($poll->poll_id, $filter);
$list->perpage = 1000;
$i = 0;
$sheet->write($i, 0, "ID");
$sheet->write($i, 1, "Дата");
$sheet->write($i, 2, "ФИО");
$sheet->write($i, 3, "% выполнения");
$sheet->write($i, 4, "Регион");
$sheet->write($i, 5, "Пол");
$sheet->write($i, 6, "Возраст");
$j = 7;
foreach($poll->active_questions AS $question) {
	$sheet->write($i, $j, "Q".$question->num);
	if(in_array($question->mode, array(0,3,4))) {
		$j++;
		$sheet->write($i, $j, "Q".$question->num);
	}
	$j++;
}

$i++;
$total_questions = sizeof($poll->active_questions);
$now = D_Core_Time::Now();

foreach($list AS $result) {
	$sheet->write($i, 0, $result->username);
	$sheet->write($i, 1, '11.11.2011');
	$sheet->write($i, 2, $result->about);
	$sheet->write($i, 3, ( 100 * $result->answers / $total_questions).' %');
	$sheet->write($i, 4, $result->user_from);
	$sheet->write($i, 5, $result->sex);
	if($result->birth != '0000-00-00') {
		$dates = explode('-', $result->birth);
		$sheet->write($i, 6, $now->year - $dates[0]);
	} else {
		$sheet->write($i, 6, '-');
	}

	$answers = Polls_Useranswer::getUserAnswersForQids($poll->qids, $result->uid);
	$j = 7;
	foreach($poll->active_questions AS $question) {
		if(isset($answers[$question->qid])) {
			$sheet->write($i, $j, $answers[$question->qid]['answers_list']);
		} else {
			$sheet->write($i, $j, "-");
		}
		if(in_array($question->mode, array(0,3,4))) {
			$j++;
			$sheet->write($i, $j, $answers[$question->qid]['own_answer']);
		}
		$j++;
	}
	// теперь загрузим ответы этого юзера на тест
	$i++;
}
// Конец листа, отправка обозревателю*/

$xls->close();
exit;
?>