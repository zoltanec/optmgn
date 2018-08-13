<?php
$items=Tree::listAll();
function get_tree($tree, $pid)
{
    if ($pid) {
	$html = '<ul> ' . "\n";
    } else {
    	$html = '<ul id="browser" class="filetree"><li><span class="root"><a class="root" id="0">корень</a></span></li>' . "\n";
    }
    foreach ($tree as $row)
    {
        if ($row->pid == $pid)
        {
            if (checkchildren($tree,$row->did)) {
        		$html .= '<li><span class="folder">' . "\n";
            } else {
            	$html .= '<li><span class="file">' . "\n";
            }
        	
            $html .= '<a id="'.$row->did.'" href="tree/list-doc/did_'.$row->did.'/">' . $row->dname . "</a></span>\n";
            if (checkchildren($tree,$row->did))
            $html .= '    ' . get_tree($tree, $row->did);
            $html .= '</li>' . "\n"; 
        }
    }
    $html .= '</ul>' . "\n";
    return $html;
}
function checkchildren($mass, $did) {
	for($i=0;$i<count($mass);$i++) {
		//var_dump($mass[$i]);exit;
		if($mass[$i]->pid==$did){
			return true;
			exit;
		}
	}
}
$T['df']= get_tree($items, 0);
?>