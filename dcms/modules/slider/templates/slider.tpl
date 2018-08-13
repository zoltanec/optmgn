<{assign var='slides' value=Slider_Slideshow::listSlideshows(12)}>
	<script type="text/javascript">
		$(document).ready(function(){
			var shift;
			var offset;
			/*Слайдер: смена картинок*/
	  		var currentSlide = 1;
	  		var total = <{sizeof($slides)}>;
	  		showSlide(currentSlide);
	  		function showSlide(id, force) {
	  		    $("div.slide_mini_baner_wrap a").removeClass("active_mini_baner");
				$("div.slide_mini_baner_wrap a").each(function(){
					if($(this).attr("href")==id)
			    		$(this).addClass("active_mini_baner");
				});
	  			if(force == null) {
	  				force = false;
	  				fadeOutPeriod = 1000;
	  				fadeInPeriod = 1000;
	  				$('#slide' + id).fadeIn(fadeInPeriod).delay(3000);
					if(total>1) {
						$('#slide' + id).queue(function(){
							currentSlide = id + 1;
							if(currentSlide > total){
								currentSlide=1;
							}
							showSlide(currentSlide);
							$(this).dequeue();
						});
						$('#slide' + id).fadeOut(fadeOutPeriod);
					
					}
	  			} else {
	  				fadeOutPeriod = 90;
	  				fadeInPeriod = 100;
	  				$('.slide_content').clearQueue();
	  				$('#slide' + currentSlide).fadeOut(fadeOutPeriod);
	  				$('#slide' + id).fadeIn(fadeInPeriod);
	  				$('#slide' + id).delay(4000);
	  			}
	  			currentSlide = id;
	      		return false;
	  		}
	  		$(".slide_content").mouseover(function(){
	  			$('#slide' + currentSlide).clearQueue();
		  	}).mouseout(function(){
				showSlide(currentSlide);
			});
	  		//Обработчик события клик по превью баннера модуля Слайдер
			$("a.navigation").click(function(){
				if($(this).hasClass("baner_left_button")) {
					id=parseInt(currentSlide)-1;
					if(currentSlide==1)
						id=total;
				} else if($(this).hasClass("baner_right_button")){
					id=parseInt(currentSlide)+1;
					if(currentSlide==total)
						id=1;
				} else {
					id=$(this).attr("href");
				}
				showSlide(id, true);
				return false;
			});
	});
</script>
</head>
<body>
<script type="text/javascript">
var i = 1;
</script>
<noscript>
<div class="no_script_container">
<div class="no_script"><b>Включите JavaScript в вашем браузере</b><br>
Уважаемый пользователь, в вашем браузере отсутствует или отключена поддержка JavaScript.<br>
Нормальная работа сайта невозможна. Пожалуйста, проверьте настройки своего браузера и включите поддержку JavaScript.</div>
</div>
</noscript>
<div id="wall_fade">
	<div id="wall_left_fade"></div>
	<div id="wall_right_fade"></div>
</div>
<div id="head_menu_wrap">
	<div id="head_menu_bg">
		<div id="menu">
			<div id="skycinema_logo">
                <a href="#main"><img  src="<{$theme.images}>/skycinema_logo.png" /></a></div>
			<div id="navigation">
				<ul class="nav">
					<li class="home_link"><a class="active" href="#main">Главная</a></li>
					<li class="list_link"><a href="#time_table">Расписание</a></li>
					<li class="way_link"><a href="#contacts">Где?</a></li>
				</ul>
				<div id="top_phone">
					<div id="phone_img"></div>
					<div id="phone_text">
						<i><span class="phone_digit">580-500</span><br />
						<span class="phone_text">телефон для справок</span></i>
					</div>
				</div>
			</div>
             <div id="social_links"><a href="http://vkontakte.ru/skycinema_mgn" id="vkontakte"></a><a href="http://www.facebook.com/groups/255993241113227/"id="facebook"></a></div>
		</div>
	</div>
</div>
<div id="slide" class="slide_show_wrapper">
	<{if sizeof($slides)>1}>
	<div class="slide_left_button"><a class="baner_left_button navigation"></a></div>
	<div class="slide_right_button"><a class="baner_right_button navigation"></a></div>
	<{/if}>
	<{foreach item=slideshow from=$slides}>
	<div class="slide_content" id="slide<{$slideshow->num}>" style="display:none;">
	<div class="slide_show_head_wrap">
		<div class="slide_show_head">
			<div class="slide_film_name"><h1 class="name"><span class="white"><{$slideshow->title}></span></h1></div>
			<div class="slide_film_date"><h1 class="date"><{$slideshow->short}></h1></div>
		</div>
	</div>
	<div class="slide_show_BANER" style="background-image: url(<{$me.content}>/news/slides/<{$slideshow->image}>);">
		<div class="baner_fade">
			<div class="baner_fade_buttons_wrap">
				<a href="<{$me.www}>/cinema/cinema-description/<{$slideshow->object_id}>" class="button_info"><span></span>Описание</a>
				<a href="<{$me.www}>/cinema/cinema-trailer/<{$slideshow->object_id}>" class="button_video"><span></span>Трейлер</a>
				<a href="<{$me.www}>/cinema/cinema-screen/<{$slideshow->object_id}>" class="button_screen"><span></span>Кадры из фильма</a>
			</div>
  		</div>
	</div>
	</div>
	<{/foreach}>
	<{if sizeof($slides)>1}>
	<div class="slide_mini_baner_wrap">
		<table>
			<tr>
				<{foreach name=minibaner item=slideshow from=$slides}>
    				<td class="slide_mini_baner" <{if $smarty.foreach.minibaner.total>7}>style="padding:0 1px"<{/if}>><a class="navigation" href="<{$slideshow->num}>">
    				<img style="<{if sizeof($slides)>8 && sizeof($slides)<11}>width:85px<{elseif sizeof($slides)>=11}>width:73px<{/if}>" id="slide<{$slideshow->num}>_preview" src="<{$me.content}>/news/slides/thumb_<{$slideshow->image}>"></a></td>
 				<{/foreach}>
			</tr>
		</table>
	</div>
	<{/if}>
