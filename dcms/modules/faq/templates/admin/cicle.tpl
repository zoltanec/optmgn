		<{foreach item=ch from=$t.child}>
		<script type="text/javascript">
	
	$("#go<{$ch.did}>").click(branch<{$ch.did}>);
	function branch<{$ch.did}>() {
		var did=$(this).attr("title");
		//alert("data sucsess");
		//alert(did);

		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(this).next("div").slideUp("slow");
			$("div#cont"+did).html('');
			
		} else {
			$(this).addClass("active");
			$(this).next("div").slideDown("slow").siblings("div:visible").slideUp("slow");
			$.ajax({
				type: "POST",
				url: "<{$run.me}>/branch",
				data: 'did='+did,
				success: function(data){
				$("div#cont"+did).html(data);
					//alert("data sucsess".did);
			   }
			});
			$(this).siblings("h2").removeClass("active");
			
		}
		
		}
</script>
<span class="folder" id="go<{$ch.did}>" title="<{$ch.did}>"><{$ch.dname}></span>
	<div id="cont<{$ch.did}>">
	</div>
		<{/foreach}>