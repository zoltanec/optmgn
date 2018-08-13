<{javascript file='comments.functions.js'}>
<{D::appendModuleNamespace('comments')}>
<{if $config->comments_active}>
	<script src="<{$config->jscripts_path}>/comments.functions.js" type="text/javascript"></script>

	<{assign var=comments_meta value=D_Core_Factory::Comments_Meta('', true, $object_id, $template)}>

	<{assign var=comments value=D_Core_Factory::Comments_List($object_id, $req->cmpage, $req->cmperpage, $order_mode)}>
	<{assign var=comments_all value=$comments->fetchPage()}>

	<{if !$comments->read_only and $form == 'top' and $readonly!=1}>
		<!-- Comments add form BEGIN-->
		<{include file="comments;comment-form"}>
		<!-- Comments add form STOP -->
	<{/if}>


<script type="text/javascript">
input_area =  document.getElementById('com_input');
D.modules.comments.init({object_id : '<{$object_id}>', order_mode : '<{$order_mode}>', perpage  : '<{$req->cmperpage}>', last_page : '<{$comments->totalpages}>', current_page : '<{$comments->page}>'});
</script>


	<h2 class="comments comments_header">#COMMENTS#</h2>
	<!-- comments data BEGIN -->

	<div id="comments_page">

	<{include file='comments;comments-page'}>

	</div>

	<div id="comments_loading_progress"><img src="<{$theme.images}>/loader.gif">загрузка комментариев...</div>
	<script type="text/javascript">
	$(window).onscroll(function(window_offset) {
		if($('#comments_loading_progress').length != 1 ) {
			return true;
		}
		var top_offset = $('#comments_loading_progress').offset().top;
		var window_height = $(window).height();
		if( window_offset < top_offset && top_offset < window_offset + window_height) {
			var result = D.modules.comments.append_next_page();
			if(!result) {
				$('#comments_loading_progress').remove();
			}
		}
	});
	</script>

	<!-- comments data END -->

	<{if !$config->comments_readonly and $form!='top' and $readonly!=1}>
	<!-- Comments add form BEGIN -->
    <{include file="comments;comment-form"}>
    <!-- Comments add form END -->
	<{/if}>
<{/if}>