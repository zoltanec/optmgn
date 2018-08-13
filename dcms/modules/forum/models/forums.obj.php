<?php

class Forums extends dObject {

	public $sid = 0;
	static protected $cachestatic = array('SectionsRoot'=> 2, 'AllSectionsList' => 600);

	static function __fetch($sid) {
    	 return  D::$db->fetchobject("SELECT * FROM #PREFIX#_forum_sections WHERE sid = $sid LIMIT 1",__CLASS__);
    }

	function __SectionsRoot() {
		$cat = D::$db->fetchlines_clear("SELECT a.cid, a.* FROM #PX#_forum_categories a",__CLASS__);
		$forums =  D::$db->fetchobjects("SELECT a.sid,a.name,a.uid,b.username FROM #PREFIX#_forum_sections a LEFT OUTER JOIN #PREFIX#_users b USING (uid) WHERE a.parent = 0",'ForumsSections');
        $grouped = array();
        foreach($forums AS &$forum) {
        	if(isset($grouped[$forum->cid])) {
        		$grouped[$forum->cid]['sections'][] = $forum;
        	} else {
        		if(isset($cat[$forum->cid])) {
        			$catinfo = $cat[$forum->cid];
        			$grouped[$forum->cid] = array('name'=> $catinfo['name'], 'sections' => array($forum));
        		} else {
        			trigger_error("No such CID{$forum->cid} for forum SID {$forum->sid}");
        		}
        	}
        }
        return $grouped;
    }

	function object_id() {
        return "forum-".$this->sid;
    }

    function __save() {
    	if($this->sid == 0 ){
    		$this->create();
    	} else {
    	    D::$db->exec("UPDATE #PREFIX#_forum_sections SET name = '{$this->name}'
       		 			WHERE sid = '{$this->sid}' LIMIT 1");
    	    return $this->sid;
    	}
    }

    static function __AllSectionsList() {
    	return D::$db->fetchlines("SELECT sid,name,parent FROM #PX#_forum_sections WHERE active");
    }

    static function getSectionChilds($sid, $level, $searchSid = 0) {
    	$resultList = '';
    	foreach(self::AllSectionsList() AS $section) {
    		if($section['parent'] == $sid) {
    			$sidSelect = ($section['sid'] == $searchSid) ? ' selected' : '';
    			$resultList.= "<option value='{$section['sid']}'{$sidSelect}>".str_repeat('&nbsp;&nbsp;&nbsp;', $level )."&nbsp;|".str_repeat('-', $level).'&nbsp;'.$section['name']."</option>\n".self::getSectionChilds($section['sid'], $level + 1);
    		}
    	}
    	return $resultList;
    }

    static function __AllSectionsTree($sid = 0) {
    	return self::getSectionChilds(1,1, $sid);
    }
}
?>