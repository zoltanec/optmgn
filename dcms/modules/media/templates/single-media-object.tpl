<{if $file->type == "picture"}>
		 <div class="content_self">
			 <a class="media_go_next" data-href="<{$me.path}>/show/<{$t.file->parentid}>/<{$file->next}>/#image">
			 <img onload='return D.modules.media.on_file_loaded();' class="media_image" src="<{$me.my_content}>/<{$file->parentid}>/<{$file->fileid}>">
			 </a>
		 </div>
	<{elseif $file->type == "video"}>
		<center>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="550" height="400" id="videoplayer_v1">
				<param name="movie" value="<{$theme.images}>/vplayer.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="window" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="lt" />
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="true" />
				<param name="FlashVars" value="videofile=<{$me.my_content}>/<{$file->parentid}>/<{$file->fileid}>&defaultstate=&hidepanel=false&cicle=false&preview=<{$me.my_content}>/thumbs/<{$file->parentid}>/<{$file->fileid}>">
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="<{$theme.images}>/vplayer.swf" width="550" height="400">
					<param name="movie" value="<{$theme.images}>/vplayer.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#000000" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="window" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="lt" />
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="allowFullScreen" value="true" />
					<param name="FlashVars" value="videofile=<{$me.my_content}>/<{$file->parentid}>/<{$file->fileid}>&defaultstate=stop&hidepanel=false&cicle=false&preview=<{$me.my_content}>/thumbs/<{$file->parentid}>/<{$file->fileid}>">
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Загрузить Adobe Flash Player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</center>
	<{else}>
		<center>
			<object type="application/x-shockwave-flash" data="http://flv-mp3.com/i/pic/ump3player_500x70.swf" height="70" width="470">
			<param name="wmode" VALUE="transparent" />
			<param name="allowFullScreen" value="true" />
			<param name="allowScriptAccess" value="always" />
			<param name="movie" value="http://flv-mp3.com/i/pic/ump3player_500x70.swf" />
			<param name="FlashVars" value="way=<{$me.my_content}>/<{$file->parentid}>/<{$file->fileid}>&amp;swf=http://flv-mp3.com/i/pic/ump3player_500x70.swf&amp;w=470&amp;h=70&amp;autoplay=0&amp;q=&amp;skin=white&amp;volume=70&amp;comment=" />
			</object>
		</center>
	<{/if}>

 <{if !empty($t.file->descr)}>
 <div class="media_descr">
  <b>Примечание:</b><br>
   <{$t.file->descr}>
 </div>
 <{/if}>