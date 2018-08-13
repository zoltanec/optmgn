<?php
function smarty_block_mini_blocks($params, $content, &$smarty,&$repeat) {
	if( $content == NULL) {
		$header = $params['header'];
		$title=$params['title'];
		$unhideble = ($params['unhideable'] == 1 ) ? " cap_unhideable" : '';
		$block_id = "mb".md5(rand());
		echo '<div class="MINI_BLOCK'.$unhideble.'" id="'.$block_id.'" title2="'.$title.'">
	<div class="cap_mini_block">
         <div class="center_blue_cap">
           <div class="cap_arrows"></div>
           <div class="post_arrow_text_div"><h3>'.$header.'</h3></div>
         </div>
       </div>
       <div class="middle_mini_block">';
	} else {
		echo $content.'</div><div class="bottom_mini_block"></div>
      </div>';
	}
}
?>