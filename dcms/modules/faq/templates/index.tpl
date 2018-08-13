	<script type="text/javascript">
	$(document).ready(function(){
	$(".faq").bind('click',showAnswer);
	function showAnswer() {
		var qid=$(this).attr("value");
		var content=$(this).next('p');
		if ($(this).hasClass("faqactive")) {
		    content.slideUp("slow");
			$(this).removeClass("faqactive");

		} else {
			if (content.html()=='') {
				$.ajax({
					type: "POST",
					url: "<{$me.www}>/faq/questions",
					data: 'qid='+qid,
					success: function(data){
					    content.html(data);
						content.slideDown("slow");
						content.children(".faq").bind('click',showAnswer);
				   }
				});
			} else {
				content.slideDown("slow");
			}
		$(this).addClass("faqactive");
		}
		return false;
	}
	});
	</script>
<div id="faq_content">
	<h1>Вопросы-ответы</h1> <!--a class="go_last" href="<{$me.www}>/feedback/">Задать вопрос</a-->
		<{foreach item=ch from=$faq->getChildren()}>
		<h4 class="faq" value="<{$ch->qid}>"><{$ch->qname}></h4>
		<p class="quest_answer"></p><!-- id="render" class="quest_answer answer<{$ch->qid}>" -->
		<{/foreach}>
</div>
<{include cid="1" file="feedback;index"}>