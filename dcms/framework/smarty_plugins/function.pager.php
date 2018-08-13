<?php
function smarty_function_pager($params,&$smarty) {
	return (isset($params['pager']) && $params['pager'] == 'fast') ? Pagers::getFastPager($params) : Pagers::getDefaultPager($params);
}

class Pagers {
	static function getFastPager($params) {
		$total = (isset($params['total'])) ? intval($params['total']) : 1;
		$current = (isset($params['current'])) ? intval($params['current']) : 1;
		$url = $params['url'];

		$prev_page = ($current > 1 ) ? $current - 1 : 1;
		$next_page = ($current < $total ) ? $current + 1 : $total;

		if($params['mode'] == 'reverse') {
			$t = $prev_page;
			$prev_page = $next_page;
			$next_page = $t;
		}

		$left_arrow  = "<a href='".str_replace('!PAGE!',$prev_page, $url)."'>&larr;</a>";
		$right_arrow = "<a href='".str_replace('!PAGE!',$next_page, $url)."'>&rarr;</a>";
		return "<table class='cms_fast_pager'>
		<tr>
		<td>{$left_arrow}</td>
		<td><input type='text' onkeypress='if(event.which==13){{$call}(this.value);}' name='page' value='{$current}'></td>
		<td class='cms_fast_pager_total'>/{$total}</td>
		<td>{$right_arrow}</td>
		</tr>
		</table>";
	}
	static function getDefaultPager($params) {
		// проверяем все параметры которые нам были переданы
		$total = (isset($params['total'])) ? intval($params['total']) : 1;
		if(!isset($params['nohide'])) {
			if($total <= 1) {
				return '';
			}
		}
		$current = (isset($params['current'])) ? intval($params['current']) : 1;
		$visible = (isset($params['visible'])) ? intval($params['visible']) : 5;
		// функция которую надо вызывать для перелистывания сообщения, она будет вызвана как function(page)
		$call = (isset($params['call'])) ? $params['call'] : false;
		// url на который надо перебрасывать
		$url = (isset($params['url'])) ? $params['url'] : '#PAGE#';
		// режим отображения
		// при режиме reverse сначала идут страницы с более высоким номером, при режиме normal наоборот
		if(isset($params['mode'])) {
			switch($params['mode']) {
				case 'reverse': $mode = 'reverse'; break;
				case 'normal': $mode = 'normal'; break;
				default: $mode = 'normal';
			}
		} else {
			$mode = 'normal';
		}
	// список страниц
	if($total <= $visible) {
    	$range = range(1, $total);
    } else {
    	$side_count = floor($visible / 2);
    	if($current + $side_count >= $total )  {
    		$range =  range($current  - $side_count, $total);
    	} elseif($current - $side_count <= 0 ) {
			$range =  range(1, $current + $side_count);
    	} else {
			$range =  range($current - $side_count ,$current + $side_count);
    	}
    }
    if($mode == 'reverse') {
    	$range = array_reverse($range);
    }
    //
    $answer = "<div class='cms_pager_container'><span class='cms_pager'>";
    // блок выбора предыдущих страниц
    $answer.= "<span class='cms_pager_prev_block'>";
    if($call) {
    	if( ( $mode == 'normal' && $current > ceil($visible/2) ) || ($mode == 'reverse' && $current < $total - floor($visible/2)) ) {
    		// первая страница в зависимости от режима
    		$begin_page = ($mode == 'normal') ? '1' : $total;
    		$answer .= "<span class='cms_pager_to_begin' title='{$begin_page}' onclick='return {$call}({$begin_page});'></span>";
    	}
    	if( ( $mode == 'normal' && $current > 1 ) || ( $mode == 'reverse' && $current < $total ) ) {
    		$left_page = ($mode == 'normal') ? $current - 1 : $current + 1;
    		$answer .= "<span class='cms_pager_prev' title='{$left_page}' onclick='return {$call}({$left_page});'></span>";
    	}
    } else {
   		if($current > 1) {
   			$answer .= "<span class='cms_pager_to_begin'></span>";
    		$answer .= "<span class='cms_pager_prev'></span>";
    	}
    	//$answer .= "<span class='cms_pager_to_end'></span>";
    }
    $answer.= "</span><span class='cms_pager_pages'>";
    // теперь формируем непосредственно
    foreach($range AS $page) {
    	$class = ($page == $current) ? ' class="selected_page"' : '';
    	if($call) {
 			$answer .= "<a title='{$page}' href='".str_replace('#PAGE#',$page,$url)."'{$class}  onclick='return {$call}({$page});'>{$page}</a>\n";
    	} else {
    		$answer .= "<a titla='{$page}' href='".str_replace('!PAGE!',$page,$url)."'{$class}>{$page}</a>\n";
    	}
    }
    $answer .= "</span><span class='cms_pager_next_block'>";
    // формируем переключение вперед и к концу
	if($call) {
    	if( ( $mode == 'normal' && $current < $total ) || ( $mode == 'reverse' && $current > 1 )) {
    		$right_page = ($mode == 'normal') ? $current + 1 : $current - 1;
    		$answer .= "<span title='{$right_page}' class='cms_pager_next' onclick='return {$call}({$right_page});'></span>";
    	}
    	if( ( $mode == 'normal' && $current < $total - ceil($visible/2)) || ( $mode == 'reverse' && $current > ceil($visible/2) )) {
    		$end_page = ($mode == 'normal') ? $total : 1;
    		$answer .= "<span title='{$end_page}' class='cms_pager_to_end' onclick='return {$call}({$end_page});'></span>";
    	}
    } else {
    	if($current < $total - $visible) {
    		$answer .= "<span class='cms_pager_to_end'></span>";
    	}
   		if($current < $total) {
    		$answer .= "<span class='cms_pager_next'></span>";
   		}
    	//$answer .= "<span class='cms_pager_to_end'></span>";
    }
    // теперь формируем переключение
    $answer .= "</span>\n</span></div>";
    return $answer;
}
};
?>