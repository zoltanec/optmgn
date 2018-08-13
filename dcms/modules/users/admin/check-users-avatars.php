<?php
$uids = array();
// генерируем запрос
$list = new D_Core_List();
$list->fetch_query("SELECT /*COLS*/a.avatar,a.uid/*/COLS*/ FROM #PX#_users a WHERE avatar != ''")->setCaching(false);
//$list->container = 'dUser';
// количество страниц используемых в запросе
$list->perpage(300);
for($i = 1; $i < $list->totalpages; $i++) {
	$list->page($i);
	$uids = array();
	// общее количество страниц с данными
	foreach($list AS $user) {
		if(!empty($user->avatar)) {
			if(!file_exists($run['my_content'].'/avatars/'.$user->avatar)) {
				// теперь обновляем информацию пользователя
				$uids[] = $user->uid;
			}
		}
	}
	if(sizeof($uids) > 0 ) {
		//var_dump($uids);
		D::$db->exec("UPDATE #PX#_users SET avatar = '' WHERE uid IN (".implode(',',$uids).")");
	}
	$list->reset();
}
D::$Tpl->RedirectOrText('~/','OK');
?>