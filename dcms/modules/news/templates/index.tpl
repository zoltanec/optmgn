<link rel="alternate" type="application/rss+xml" title="Новости Металлург.RU" href="<{$me.path}>/rss-latest/" />
<table id="index_container">
 <tr>
  <td id="index_left_block">
<div id="slideshow">
<{assign var='slides' value=Slideshow::listSlideshows(5)}>
 <div class="slideshow_slide_block">
<{foreach item=slideshow from=$slides}>
<table onclick="document.location.href='<{$slideshow->url}>';" id="slide<{$slideshow->num}>" class="changable_news" style="display: none; background-image: url(<{$me.my_content}>/slides/<{$slideshow->image}>);">
 <tr><td>&nbsp;</td></tr>
 <tr><td class="cn_title"><a href="<{$slideshow->url}>"><{$slideshow->title}></a><div><{$slideshow->short}></div></td></tr>
</table>
<{/foreach}>
</div>
<ul id="news_slider">
 <{foreach item=slideshow from=$slides}>
    <li><a href="#" onclick='return forceSlide(<{$slideshow->num}>);'><img id="slide<{$slideshow->num}>_preview" src="<{$me.my_content}>/slides/<{$slideshow->image}>"></a></li>
 <{/foreach}>
 </ul>
<script>
var currentSlide = 1;
var total = <{sizeof($slides)}>;
showSlide(1);
slideshowIntervalWorker = setInterval( function() {
		nextSlide = currentSlide + 1;
		if(nextSlide > total) {
			showSlide(1);
		} else {
			showSlide(nextSlide);
		}
	}, 600000);

function forceSlide(slideId) {
	clearInterval(slideshowIntervalWorker);
	showSlide(slideId, true);
	return false;
}
function showSlide(id, force) {
	if(force == null) {
		force = false;
		fadeOutPeriod = 1300;
		fadeInPeriod = 1200;
	} else {
		fadeOutPeriod = 100;
		fadeInPeriod = 90;
	}
	slideOffset = $('#slide' + currentSlide).offset();
	$('#slide' + currentSlide).css('position', 'absolute').css('left', slideOffset.left + 'px').css('top',slideOffset.top + 'px').fadeOut(fadeOutPeriod, function() {
		$(this).css('position', 'static');
		});
	$('#slide' + id).fadeIn(fadeInPeriod);
	// document.getElementById('slide'+currentSlide).style.display = 'none';
    $('#slide'+currentSlide+'_preview').css('border-color' ,'white');
    $('#slide'+currentSlide+'_preview').css('border-width', '2px');
   // document.getElementById('slide'+id).style.display = 'table';
    $('#slide'+id+'_preview').css('border-color', 'red');
    $('#slide'+id+'_preview').css('border-width', '2px');
    currentSlide = id;
    return false;
}
function showTab(tab, all_tabs) {
	var tabs = all_tabs.split(';');
	for( i in tabs ) {
		document.getElementById(tabs[i]).style.display = 'none';
		document.getElementById('select_'+ tabs[i]).className = 'tab_inactive';
	}
	document.getElementById('select_' + tab).className = 'tab_active';
	document.getElementById(tab).style.display = 'block';
}

function showHideWidget(widgetId) {
	var widget = $('#' + widgetId);
	if( widget.is(':visible')) {
		widget.hide();
	} else {
		widget.show();
	}
}
$(document).ready(function() {
	$('.selecter_header').bind('click', function() {
		var controledBlock = '#' + $(this).attr('title');
		if( $(controledBlock).is(':visible')) {
			$(controledBlock).hide();
			$(this).find('IMG').attr('src', '<{$theme.images}>/tabs/plus.png');
		} else {
			$(controledBlock).show();
			$(this).find('IMG').attr('src', '<{$theme.images}>/tabs/minus.png');
		}
		//alert( $(this).attr('title'));
	});
	$('.selecter_header').each(function(index) {
		controlledBlock = '#' + $(this).attr('title');
		if( $(this).is('.default_hided')) {
			$(controlledBlock).hide();
		}
		if($(controlledBlock).is(':visible')) {
			mode = 'minus';
		} else {
			mode = 'plus';
		}
		$(this).prepend('<img src="<{$theme.images}>/tabs/' + mode + '.png">');
	});
});
</script>
</div>

<div class="main_news">Новости</div>
<{foreach item=news from=$t.news}>
    <div class="news_block">
        <div class="news_header">
            <a class="news_title" href="<{$me.path}>/read/<{$news->nid}>/"><{$news->title}></a> / <a class="news_section_name" href="<{$me.path}>/archive/<{$news->sid}>/"><{$news->section_name}></a>
        </div>

        <div class="news_short_content"><{$news->short}>&hellip;

          <span class="news_stat_block">
          <{if $news->comments > 0}><a class="news_discuss" href="<{$me.path}>/comments/<{$news->nid}>/">обсуждения</a><{/if}>
                ( <img src="<{$theme.images}>/read.gif"><{$news->readed}>
             <{if $news->comments_status}>
              <img src="<{$theme.images}>/comment.gif"><span class="news_comments"><{$news->comments}></span>
             <{/if}>
                  )
          </span>
          <div class="news_details">
            <div class="news_source_menu">Источник:&nbsp;<b><{$news->source}></b> / Добавлено: <{$news->addtime|convert_time}> /

              <a class="details" href="<{$me.path}>/read/<{$news->nid}>/">Подробнее&raquo;</a>
            </div>
         </div>
       </div>
     </div>
<{/foreach}>
</td>
<td id="index_right_block">
<{include file='dwidget:counter'}>

<{include tag='main' widget_mode='widgetonly' file='dwidget:vote'}>

<!-- это блок турнирной таблицы и календаря для КХЛ и взрослых игр -->

<{mini_blocks header='Результаты'}>
 	<{include tournament_id='1' mode='events' file='dwidget:turnirtable'}>
<{/mini_blocks}>

<{mini_blocks header='ПЛЕЙ-ОФФ КХЛ'}>
  <{include file='news;playoff'}>
<{/mini_blocks}>


<{mini_blocks header='ПЛЕЙ-ОФФ 1/8'}>
	<{include tournament_id=7 round_needed='4' file='dwidget:turnirtable;playoff'}>
<{/mini_blocks}>


<{mini_blocks header='КХЛ'}>
<div class="tournament_table" id="turnir1">
	<{include tournament_id='1' file='dwidget:turnirtable'}>
</div>
<{/mini_blocks}>

<{mini_blocks header='Test'}>
	<{include file='news;playoff-mhl'}>
<{/mini_blocks}>




<!-- Конец блока КХЛ -->

<!-- Блок турнирки и календаря для молодежи -->
<!--
<div class="right_tab_block">

	<div class="selecter_header" onclick="return showHideWidget('widgetResultsFoxes');">Результаты МХЛ 2010-2011</div>
	<div class="hideable_widget" style="display: none;" id="widgetResultsFoxes">
		<{include tournament_id='3' mode='events' file='dwidget:turnirtable'}>
	</div>

-->
<{mini_blocks header='МХЛ 2010-2011'}>
	<{include tournament_id='3' file='dwidget:turnirtable'}>
<{/mini_blocks}>



<img style="cursor: pointer;" onclick='return showPlayoff();' src="<{$theme.images}>/playoff.button.png">

<img style="border: 0px;" usemap="#button_map" src="<{$theme.images}>/topbuttons.png">
<map name="button_map">
<area shape="rect" coords="2,4,68,69" href="http://ditinform.ru/" />
<area shape="rect" coords="71,4,136,66" href="http://vkontakte.ru/club5458312" />
<area shape="rect" coords="141,5,205,68" href="http://m.metallurg.ru/site/news/" />
<area shape="rect" coords="208,5,273,67" href="http://www.metallurg.ru/site/news/rss-latest/" />
<area shape="rect" coords="276,5,341,68" href="#" onclick="return showModal();" />
</map>

<div style="margin: 0 auto;   text-align: center;">
<object style="margin: 0 auto;" width="348" height="348">
<param name="movie" value="<{$theme.images}>/belmag.swf">
<embed src="<{$theme.images}>/belmag.swf" width="348" height="348">
</embed>
</object>
</div>

</td>
</tr>
</table>

<div id="modal_window_back">
</div>

<div id="modal_playoff" class="modal_window_block">
  <div class="modal_window_content">
    <table class="table">
     <tr>
      <td colspan="3" class="header">Заявка на Плей-Офф для владельцев абонементов</td>
     </tr>
    <tr>
      <td>Фамилия:</td>
      <td colspan="2"><input type="text" id="playoff_surname" name="surname"></td>
     </tr>


     <tr>
       <td>Имя:</td>
       <td colspan="2"><input type="text" id="playoff_name" name="name"></td>
     </tr>



     <tr>
      <td>Отчество:</td>
      <td colspan="2"><input type="text" id="playoff_secname" name="secname"></td>
     </tr>

     <tr>
      <td>Место:</td>
      <td nowrap>сектор <select name="sector" id="playoff_sector">
        <option value="1">1
        <option value="2">2
        <option value="3">3
        <option value="4">4
        <option value="5">5
        <option value="6">6
        <option value="7">7
        <option value="8">8
        <option value="9">9
        <option value="10">10
        <option value="11">11
        <option value="12">12
        <option value="13">13
        <option value="14">14
        <option value="15">15
        <option value="16">16
        <option value="A">A
        <option value="B">B
        <option value="C">C
      </select>

      ряд: <select name="row" id="playoff_row">
       <{foreach item=row from=range(1,19)}>
        <option value="<{$row}>"><{$row}>
       <{/foreach}>
      </select>

      место <select name="place" id="playoff_place">
       <{foreach item=place from=range(1,35)}>
        <option value="<{$place}>"><{$place}>
       <{/foreach}>
      </select>
     </td>
    </tr>

   <tr>
    <td>Подтверждаю подлинность предоствленных данных:</td>
    <td><input type="checkbox" id="playoff_approve"></td>
   </tr>

    <tr>
      <td>
     <tr>
      <td>Номер телефона:
       <div class="help">Формат: 7XXXXXXXXXX</div>
      </td>
      <td><input type="text" id="playoff_phone" name="phone"></td>
      <td><button id="playoff_submit_phone">Получить код</button></td>
     </tr>

     <tr>
      <td>Проверочный код:
       <div class="help">Введите код, который пришел вам в SMS сообщении</div>
      </td>
      <td><input type="text" id="playoff_code" name="code"></td>
      <td><button id="playoff_submit_code">Отправить заявку</button></td>
     </tr>
    </table>
  </div>
  <div class="modal_window_control"><button class="close_modal" id="close_modal_playoff">Закрыть</button></div>
</div>


<div class="modal_window_block" id="block_subscribe">
  <div class="modal_window_content">
    <table class="table">
     <tr>
      <td colspan="3" class="header">SMS-рассылка от ХК &laquo;Металлург&raquo;</td>
     </tr>

     <tr>
      <td>Номер телефона:
       <div class="help">Формат: 7XXXXXXXXXX</div>
      </td>
      <td><input type="text" id="subscribe_phone" name="phone"></td>
      <td><button id="subscribe_phone_submit">Отправить SMS</button></td>
     </tr>

     <tr>
      <td>Проверочный код:
       <div class="help">Введите код, который пришел вам в SMS сообщении</div>
      </td>
      <td><input type="text" id="subscribe_code" name="code"></td>
      <td><button id="subscribe_code_submit">Проверить код</button></td>
     </tr>
    </table>
  </div>
  <div class="modal_window_control"><button class="close_modal" id="close_modal_subscribe">Закрыть</button></div>
</div>

<script type="text/javascript" src="<{$config->jscripts_path}>/local.functions.js"></script>





