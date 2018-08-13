<script type="text/javascript">
$(document).ready(function () {
  //  var tabcontainer = $('.tabs_cont div'); // получаем массив контейнеров
   // tabcontainer.hide().filter(':first').show(); // прячем все, кроме первого
    // далее обрабатывается клик по вкладке
   // $('.st_tabs li a').click(function () {
     //   tabcontainer.hide(); // прячем все таб-контейнеры
      //  tabcontainer.filter(this.hash).show(); // показываем содержимое текущего
       // $('.st_tabs li a').removeClass('active'); // у всех убираем класс 'active'
       // $(this).addClass('active'); // текушей вкладке добавляем класс 'active'
       // return false;
   // }).filter(':first').click();
    $('#mode').bind('change', selectMode);
    function selectMode () {
	    //alert($("#mode :selected").val());
	    if($("#mode :selected").val()=='html'){
			$("#rich_parent").html('');
			$("#rich").show();
		} else {
		    tinyMCE.init({
			mode : "exact",
			elements: "rich",
			theme : "advanced",
			language:"en",
			plugins : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
		 	theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			plugi2n_insertdate_dateFormat : "%Y-%m-%d",
			plugi2n_insertdate_timeFormat : "%H:%M:%S",
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : false,
			paste_auto_cleanup_on_paste : true,
			paste_convert_headers_to_strong : false,
			paste_strip_class_attributes : "all",
			paste_remove_spans : false,
			paste_remove_styles : false,
			verify_html : false,
			inline_styles : false,
			relative_urls : false,
			convert_urls: false
			});
		}
    }
});
</script>
<H1>Редактирование страницы  N<{$page->content_id}> <{if $page->content_name}>( <{$page->content_name}> )<{/if}></H1>
<!-- <ul class="tabs">
<li><a class="tab" href="#main">Общие настройки</a></li><li><a class="tab active" href="#mtags">Ключевые слова и метатеги</a></li><li><a class="tab" href="#prview">Предпросмотр страницы</a></li>
</ul> -->
<div class="tabs_cont">
<form method="post" action="<{$run.me}>/update-page/">
<input type="hidden" name="content_id" value="<{$page->content_id}>">
 <div id="main">
 <table class="cms_form">
 <tr>
  <td>Псевдоним:
     <div class="help">Псевдоним используется для более удобного доступа к странице, например страница
     с псевдонимом <b>verycoolpage</b> будет доступна как <i><{$run.path}>/verycoolpage/</i> . Псевдоним должен быть уникален.</div>
  </td>
  <td><input type="text" name="content_name" size="60" value="<{$page->content_name}>"><br>
   <i>Адрес: <a href="<{$run.path}>/<{$page->content_name}>/" target="_blank"><{$run.path}>/<{$page->content_name}>/</a></i>
  </td>
 </tr>
   <tr>
  	<td>Заголовок:</td>
  	<td><input type="text" name="title" size="60" value="<{$page->title}>" /></td>
  </tr>

 <tr>
  <td>Описание ( description ):<div class="help">Описание используется поисковыми системами для определения тематики материала.</div></td>
  <td><input type="text" name="description" size="60" value="<{$page->description}>"></td>
 </tr>

 <tr>
  <td>Язык:</td>
  <td><select name="lang">
   <{foreach item=language from=$config->languages}>
    <option value="<{$language}>"<{if $language == $page->lang}> selected<{/if}>><{$language}>
   <{/foreach}>
  </select>
 </td>
 </tr>
 <tr>
  	<td>Страница активна:</td>
  	<td><input type="checkbox" name="active"<{if $page->active}> checked<{/if}>></td>
  </tr>
  <tr>
   <td>Комментарии:</td>
   <td><input type="checkbox" name="comments"<{if $page->comments}> checked<{/if}>></td>
  </tr>
 <tr>
  <td>Режим статистики:</td>
  <td><select name="stat_mode">
    <option value="1"<{if $page->stat_mode==1}> selected<{/if}>>не собирать статистику</option>
    <option value="2"<{if $page->stat_mode==2}> selected<{/if}>>считать количество просмотров и время последнего доступа,общая статистика</option>
    <option value="3"<{if $page->stat_mode==3}> selected<{/if}>>собирать статистику по каждому просмотру,IP и время, без общей</option>
    <option value="4"<{if $page->stat_mode==4}> selected<{/if}>>собирать полную статистику, включая общую и детальную</option>
  </select>
  </td>
 </tr>
 <tr>
 <td>Режим редактирования содержимого</td><td>
   <select id="mode" name="mode">
   		<option value="edit">Редактор</option>
   		<option value="html">Исходный код</option>
   </select>
  </td>
 </tr>
 <tr>
 <td colspan="2"><b>Содержимое раздела</b><br>
   <textarea id="rich" name="content" rows="25" cols="150"><{$page->content}></textarea>
  </td>
 </tr>
 <tr>
  <td colspan="2"><input type="submit" class="submit_update" value="#SAVE#"></td>
 </tr>
</table>
</form>
</div>
 </div>