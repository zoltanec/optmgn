<li>
	<div class="tree_node">
		<{textformat indent=$tree_paragraph indent_char="<img class='tree_paragraph' src='<{$theme.admin.images}>/px.png' />"}>
		<{/textformat}>
		<img class="tree_toggle toggle_minus" src="<{$theme.admin.images}>/px.png" />
		<span class="folder_node node" 
			data-id="<{$tree_node->content_id}>" 
			data-active="<{$tree_node->active}>" 
			data-menu="<{$tree_node->menu}>" 
			data-object-id="<{$tree_node->object_id()}>"><{$tree_node->pagetitle}></span>
	</div>
	<{if count($tree_object)}>
		<ul>
		<{show_tree tpl_path=$tpl_path tree_object=$tree_object tree_paragraph=$tree_paragraph}>
		</ul>
	<{/if}>
</li>