<li <{if $tree_node->checkActive()}>class="active"<{elseif $tree_node->node_opened}>class="open"<{/if}>>
	<a href="<{$tree_node->HURL}>" title="<{$tree_node->pagetitle}>">
		<{if $img_path}><img src="<{$img_path}>/<{$tree_node->alias}>.jpg" /><{/if}>
		<{$tree_node->menutitle}>
	</a>
	<{if $menu_type=='vertical'}><span><{$tree_node->menutitle}></span><{/if}>
</li>