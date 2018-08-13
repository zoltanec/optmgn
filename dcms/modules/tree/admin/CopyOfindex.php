<?php
$items=D::$db->fetchlines("SELECT * FROM #PX#_tree");
foreach($tree as $value) {
	if ($value['pid']==0) {
		//$tree[$value['pid']]
		
		//var_dump($value['dname']);	
	}
}
 	
 	function buildTree(array $listItems) {
 	  // Подготовка ID корневого узла.
 	  $rootId = array();
 	  $tree = array();
	  // Обход списка и обработка узлов.
 	  foreach ($listItems as $id => $node) {
 	    if ($node['pid']) {
 	      // Сохранение в родительском узле ссылки на текущий.
 	      $listItems[$node['pid']]['sub'][$id] =&$listItems[$id];
 	    } else {
	      // Сохранение ссылки на корневой элемент.
 	      $rootId[] = $id;
 	    }
 	  }
 	  foreach ($rootId as $id){
 	  	$tree[]=array($id => $listItems[$id]);
 	  }
 	  // Возврат корневого узла, содержащего всё построенное дерево.
 	  return $tree;
 	}
 	$ms=buildTree($items);
 	array_walk_recursive($ms,'test');
 	$tr="<ul id=\"browser\" class=\"filetree\">";
 	function test($item, $key) 
{
    if ($key=="pid" && $item==0)
    $tr.="<li><span class=\"folder\">фывфы</span>";
	echo "$key holds $item\n";

}
?>