<?php
$qid=D::$req->int('qid');
$T['faq'] = D::$db->fetchline("SELECT * FROM #PX#_faq WHERE qid={$qid}");
?>