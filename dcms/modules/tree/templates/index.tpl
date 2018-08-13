<script type="text/javascript">
$(document).ready(function(){
	$(".blog_subtitle").bind('click',showdoc);
	function showdoc() {
		var did=$(this).attr("value");
		var content=$(this).next('div');
		if ($(this).hasClass("blog_active")) {
		    content.slideUp("slow");
			$(this).removeClass("blog_active");
		} else {
			if (content.html()=='') {
				$.ajax({
					type: "POST",
					url: "<{$me.www}>/tree/branch",
					data: 'did='+did,
					success: function(data){
					    content.html(data);
						content.slideDown("slow");
						content.children(".blog_subtitle").bind('click',showdoc);
				   }
				});
			} else {
				content.slideDown("slow");
			}
		$(this).addClass("blog_active");
		}
		return false;
	}
});
</script>
<div id="blog_wrap">
		<h2 class="blog_h2"><span>«Металлург»:</span> история в деталях</h2>
		<div class="blog_profile"><img src="<{$theme.images}>/ribachenko.png" /><br /><i>Авторская рубрика<br />
			<span>Владислава Рыбаченко</span></i>
		</div>
		<p>Память не способна сохранить все, что происходит с человеком и вокруг него. Она бережет только самые главные, важные, святые минуты жизни. Но этим историческим эпизодам предшествуют годы, а то и десятилетия напряженного труда, без которого штурм любой вершины невозможен.</p>
  		<p>Магнитогорский «Металлург» превратился в одного из главных законодателей российской хоккейной моды, завоевал все возможные для европейского клуба титулы, создал инфраструктуру, позволяющую в родном городе растить мастеров мирового класса. Однако на пути к успехам хоккейная Магнитка прошла долгий путь. Истории клуба, его руководителям, игрокам, тренерам, сделавшим возможным восхождение на Олимп, любопытным деталям и нюансам из биографии «Металлурга» посвящен этот раздел.</p>
		<p>Посетители сайта могут задать любой «исторический» вопрос, касающийся магнитогорского хоккея (меню «Напишите мне»).</p>
		<div class="blog_end_letter"><span>Владислав РЫБАЧЕНКО,</span> автор раздела.</div>
		<div class="blog_section"><div class="blog_title"><img src="<{$theme.images}>/blog/names.png" />Имена на все времена</div>
	 		<{foreach item=blog from=Tree::getByPid(149)}>
	 			<h4 class="blog_subtitle" value="<{$blog->did}>"><{$blog->dname}></h4>
				<div class="blog_content"></div>
	 		<{/foreach}>
		</div>
		<div class="blog_section"><div class="blog_title"><img src="<{$theme.images}>/blog/figure.png" />Занимательные цифры</div>
			 <{foreach item=blog from=Tree::getByPid(150)}>
	 			<h4 class="blog_subtitle" value="<{$blog->did}>"><{$blog->dname}></h4>
				<div class="blog_content"></div>
	 		<{/foreach}>
		</div>
		<div class="blog_section"><div class="blog_title"><img src="<{$theme.images}>/blog/best.png" />Best of the best</div>
			 <{foreach item=blog from=Tree::getByPid(151)}>
	 			<h4 class="blog_subtitle" value="<{$blog->did}>"><{$blog->dname}></h4>
				<div class="blog_content"></div>
	 		<{/foreach}>
		</div>
		<div class="blog_section"><div class="blog_title"><img src="<{$theme.images}>/blog/fing.png" />Бывает и такое</div>
			<{foreach item=blog from=Tree::getByPid(152)}>
	 			<h4 class="blog_subtitle" value="<{$blog->did}>"><{$blog->dname}></h4>
				<div class="blog_content"></div>
	 		<{/foreach}>
		</div>
		<div class="blog_send_me_wrap">
			<div class="blog_messages_title"><img src="<{$theme.images}>/blog/blog_mail.png" /> Напишите мне</div>
			<div class="blod_message_left"><textarea></textarea></div>
			<div class="blod_message_right">
				<div><input type="text" value="Ваше имя" /></div>
				<div><input type="text" value="E-mail" /></div>
			</div>
		</div>
</div>