<?php
$data = "";
try {
	$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->redirect('~/');
}
$search_id = D::$req->textID('param4');
if ($search_id != '' && isset($_SESSION['result_search_'.$search_id])) {
	$filter = $_SESSION['result_search_'.$search_id];
} else {
	$filter = array();
}
error_reporting(0);


$list = Polls_Useranswer::getResultsList($poll->poll_id, $filter);
$list->perpage = 1000;
$i = 0;

/**$sheet->write($i, 0, "ID");
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
foreach($poll->active_questions AS $question) {
	$sheet->write($i, $j, "Q".$question->num." t,c");
	$j++;
}

$i++;
$total_questions = sizeof($poll->active_questions);
$now = D_Core_Time::Now();
*/
// first we need to create list of all users in selection
$users = "";
$now = D_Core_Time::Now();

foreach($list AS $result) {
	if($result->birth != '0000-00-00') {
		$dates = explode('-', $result->birth);
		$age = $now->year - $dates[0];
	} else {
		$age = '-';
	}
	$users.="<user>
<id>{$result->username}</id>
<name><![CDATA[{$result->about}]]></name>
<sex>{$result->sex}</sex>
<birth>{$result->birth}</birth>
<age>{$age}</age>
<from><![CDATA[{$result->user_from}]]></from>
</user>";
}
$data.="<users>".$users."</users>";

$questions = "";

// now lets fill
foreach($poll->active_questions AS $question) {
	$q = "";
	$q.= "<question>";
	$q.= "<content><![CDATA[".$question->question."]]></content>";
	$q.= "<mode>".$question->mode."</mode>";
	$q.= "<code>".$question->num."</code>";
	$q.= "<mode_name><![CDATA[".D::$i18n->getTranslation(Polls_Question::getQuestionModeName($question->mode))."]]></mode_name>";
	$q.="<variants>";
	foreach($question->getAnswers() AS $answer) {
		$q.= "<variant><![CDATA[".$answer."]]></variant>";
	}
	$q.="</variants></question>";
	$questions.= $q;
}
$data.="<questions>".$questions."</questions>";

// and now lets create results output
$all_answers = "";
foreach($list AS $answer) {
	$a = "<useranswers id='{$result->username}'>";
	$answers = Polls_Useranswer::getUserAnswersForQids($poll->qids, $result->uid, 'clear');

	foreach($poll->active_questions AS $question) {
		if(isset($answers[$question->qid])) {
		$a.= "<question code='{$question->num}'>";
		$a.="<content><![CDATA[".$question->question."]]></content>";
		$answered = explode(',', $answers[$question->qid]['answers_list']);
		foreach($question->getAnswers() AS $code => $value) {
			if(in_array($code, $answered)) {
				$a.="<answer code='{$code}'><![CDATA[".$value."]]></answer>";
			}
		}
		if(in_array($question->mode, array(0,3,4))) {
			$a.="<answer code='own'><![CDATA[".$answers[$question->qid]['own_answer']."]]></answer>";
		}
		$a.="</question>";
	}
	}
	$a.= "</useranswers>";
	$all_answers.= $a;
}
$data.="<answers>".$all_answers."</answers>";

/**
foreach($list AS $result) {
	$sheet->write($i, 0, $result->username);
//	$sheet->write($i, 1, '11.11.2011');
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

	$answers = Polls_Useranswer::getUserAnswersForQids($poll->qids, $result->uid, 'clear');
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
	foreach($poll->active_questions AS $question) {
			$sheet->write($i, $j, $answers[$question->qid]['think_time']." c");
			$j++;
	}
	// теперь загрузим ответы этого юзера на тест
	$i++;
}*/
header("Content-type: text/xml; charset = utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?><export>'.$data.'</export>';
exit;

?>