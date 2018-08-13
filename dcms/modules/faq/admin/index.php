<?php
$items=D::$db->fetchlines("SELECT * FROM #PX#_faq");

function get_tree($tree, $pid)
{
    if ($pid) {
	$html = '<ul> ' . "\n";
    } else {
    	$html = '<ul id="browser" class="filetree"><li><span class="root"><a class="root" id="0">корень</a></span></li>' . "\n";
    }
 
    foreach ($tree as $row)
    {
        if ($row['pid'] == $pid)
        {
            //if (isset($tree[]["pid"]==$row['did']))
            if (checkchildren($tree,$row['qid'])) {
        		$html .= '<li><span class="folder">' . "\n";
            } else {
            	$html .= '<li><span class="file">' . "\n";
            }
        	
            $html .= '<a id="'.$row['qid'].'" href="faq/list-doc/qid_'.$row['qid'].'/">' . $row['qname'] . "</a></span>\n";
            if (checkchildren($tree,$row['qid']))
            $html .= '    ' . get_tree($tree, $row['qid']);
            $html .= '</li>' . "\n";
            
        }
    }
 
    $html .= '</ul>' . "\n";
 
    return $html;
}
function checkchildren($mass, $did) {
	for($i=0;$i<count($mass)-1;$i++) {
		if($mass[$i]['pid']==$did){
			return true;
			exit;
		}
	}
}
$T['filetree']= get_tree($items, 0);
?>