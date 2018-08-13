<{assign var='slides' value=Slider_Slideshow::listSlideshows(12)}>
<script type="text/javascript">
	$(document).ready(function(){
		var currentSlide = 1;
		var total = <{sizeof($slides)}>;
		function showSlide(id) {
			var current=$("img#slide"+currentSlide);
			var next=$("img#slide"+id);
			//alert(next.length);
			if(!next.length){
				var clone=current.clone().attr({"src":$('#pr_slide' + id).attr("data-href"),"id":"slide"+id});
				if(id-currentSlide>0){
					next=current.after(clone);
				}else{
					next=current.before(clone);
				}
				$('#slider_shadow').show();
				$("img#slide"+id).load(function(){
					$('#slider_shadow').fadeOut();
					//next.css("display","block");
					current.hide();
				});
			}else{
				next.css("display","block");
				current.hide();
			}
			currentSlide = id;
			return false;
		}
		//Обработчик события клик по превью баннера модуля Слайдер
		$("div.nav").click(function(){
			if($(this).hasClass("inter_arrow_left")) {
				id=parseInt(currentSlide)-1;
				if(currentSlide==1)
					id=total;
			} else if($(this).hasClass("inter_arrow_right")){
				id=parseInt(currentSlide)+1;
				if(currentSlide==total)
					id=1;
			}
			showSlide(id);
			return false;
		});
});
</script>
<{if sizeof($slides)>1}>
<div class="inter_slider">
	<div class="nav inter_arrow_left"></div>
	<div class="nav inter_arrow_right"></div>
</div>
<{/if}>
<div id="slider">
	<div id="slider_shadow">
		<img id="slide_preloader" src="<{$theme.images}>/preloader_2.gif" />
	</div>
	<{foreach name=slides item=slideshow from=$slides}>
	<{if $smarty.foreach.slides.index==0}>
		<img class="slide" id="slide1" src="<{$me.content}>/slider/slides/<{$slideshow->image}>" />
	<{/if}>
	<noindex style="display:none">
		<span id="pr_slide<{$slideshow->num}>" data-href="<{$me.content}>/slider/slides/<{$slideshow->image}>"></span>
	</noindex>
<{/foreach}>
</div>

