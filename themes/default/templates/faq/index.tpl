<script type="text/javascript">
$(document).ready(function(){
	$("ul.for_seo").hide();
	$(".text_big_link").live('click',showAnswer);
	function showAnswer() {
		var qid=$(this).attr("data-qid");
		var content=$(this).next('div');
		if ($(this).hasClass("active")) {
		    content.slideUp("slow");
			$(this).removeClass("active");
			
		} else {
			if (content.html()=='') {
				$.ajax({
					type: "POST",
					url: "<{$me.www}>/faq/questions",
					data: 'qid='+qid,
					success: function(data){
					    content.html(data);
						content.slideDown("slow");
				   }
				});
			} else {
				content.slideDown("slow");
			}
			$(this).addClass("active");
		}
		return false;
	}
});
</script>
<div id="faq_content">
	<ul class="for_seo">
		<{foreach item=ch from=$faq->getChildren()}>
		<li><a alt="<{$ch->qname}>" title="<{$ch->qname}>" href="<{$me.www}>/faq/show/qid_<{$ch->qid}>"><{$ch->qname}></a>
		</li>
		<{/foreach}>
	</ul>	
	<ul class="text_cont_list">
		<{foreach item=ch from=$faq->getChildren()}>
		<li><a class="text_big_link" href="#" data-qid="<{$ch->qid}>"><{$ch->qname}></a><{*<a style="text-decoration:none;" title="<{$ch->qname}>" href="<{$me.www}>/faq/show/qid_<{$ch->qid}>"><span style="font-size:2%;"><{$ch->qname}></span></a>*}>
			<div class="text_content"></div>
		</li>
		<{/foreach}>
	</ul>	
</div>