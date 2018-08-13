<li>
	<a href="<{$me.www}>/<{$tree_node->HURL}>" title="<{$tree_node->title}>"><{$tree_node->title}></a>
	<{if $tree_childrens}>
		<ul class="sub_menu">
			<{show_tree tpl_path=$tpl_path tree_object=$tree_object tree_paragraph=$tree_paragraph}>
		</ul>
	<{/if}>
</li>