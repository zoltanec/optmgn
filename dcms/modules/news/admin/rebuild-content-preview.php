<?php
$uids = array();
// генерируем запрос
$list = new dList();
$list->fetch_query("SELECT /*COLS*/a.content, a.nid/*/COLS*/ FROM #PX#_news a WHERE a.content_preview = '' ORDER BY nid DESC")->setCaching(false);
//$list->container = 'dUser';
// количество страниц используемых в запросе
$list->perpage(1000);
//$total = $news->totalpages;
$total = $list->totalpages;
for($i = 1; $i < $total; $i++) {
    echo "Page {$i}<br>";
	$list->page($i);
	// общее количество страниц с данными
	foreach($list AS $news) {
		echo  "Work {$news->nid}<br>";
		if(!empty($news->content)) {
              if(strlen($news->content) <= 1000) {
                  $preview = $news->content;
              } else {
                  $preview = mb_substr($news->content,0,strpos($news->content,' ', 1000));
              }
			$preview = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags(addslashes($preview)));
			D::$db->exec("UPDATE #PX#_news SET content_preview = '{$preview}' WHERE nid = '{$news->nid}' LIMIT 1");
			echo "Updated {$nid}<br>\n";
		}
	}
	$list->reset();
}
exit;
?>