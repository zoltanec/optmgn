<script type="text/javascript">
$(document).ready(function(){
	$("a.go").click(branch);
	$(".doc").bind('click',showdoc);
	function branch(){
		var did=$(this).attr("value");
		$("a.go").removeClass("go_active");
		$.ajax({
			type: "POST",
			url: "<{$me.www}>/tree/branch",
			data: 'did='+did,
			success: function(data){
				$("div#cont").html(data);
				$(".doc").bind('click',showdoc);
		    }
		});
		if (!$(this).hasClass("go_active")) {
			$(this).addClass("go_active");
		} else {
		    $(this).removeClass("go_active");
		}
		return false;
	}
	function showdoc() {
		var did=$(this).attr("value");
		var content=$(this).next('p');
		if ($(this).hasClass("docactive")) {
		    content.slideUp("slow");
			$(this).removeClass("docactive");
			
		} else {
			if (content.html()=='') {
				$.ajax({
					type: "POST",
					url: "<{$me.www}>/tree/branch",
					data: 'did='+did,
					success: function(data){
					    content.html(data);
						content.slideDown("slow");
						content.children(".doc").bind('click',showdoc);
				   }
				});
			} else {
				content.slideDown("slow");
			}
		$(this).addClass("docactive");
		}
		return false;
	}
});
</script>
<div class="CENTER">
	<h1><{$doc->dname}></h1>
	<div id="left_nav">
		<ul class="left_nav">
		<{foreach item=folder name=menubar from=$doc->getChildren()}>
			<li><a class="go <{if $smarty.foreach.menubar.index==0}>go_active<{/if}> <{*if $smarty.foreach.menubar.last}>go_last<{/if*}>" value="<{$folder->did}>"><{$folder->dname}></a></li>
		<{/foreach}>
		</ul>
	</div>
	<div id="cont">
		<{*$doc->dcontent*}>
			<p><{$chdoc->dcontent}>
			<{foreach item=ch from=$chdoc->getChildren()}>
			<h4 class="doc" value="<{$ch->did}>" title="<{mb_strtolower($ch->dname)}>"><{$ch->dname}></h4>
				<p class="doc_cont"></p>
			<{/foreach}></p>
	</div>
</div>


