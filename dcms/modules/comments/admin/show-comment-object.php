<?php
// получение информации об объекте комментирования
try {
	$object = dFactory::dCommentsMeta(D::$req->textLine('param3'));
} catch (Exception $e) {
	echo "NO_SUCH_OBJECT";
}
$T['object'] = &$object;
?>