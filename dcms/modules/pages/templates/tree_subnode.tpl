<{if $menu_type=='vertical'}>
	<li <{if $tree_node->checkActive()}>class="active"<{elseif $tree_node->node_opened}>class="open"<{/if}>>
		<a href="<{$tree_node->HURL}>" 
			title="<{$tree_node->pagetitle}>">
			<{if $img_path}><img src="<{$img_path}>/<{$tree_node->alias}>.jpg" /><{/if}>
			<{$tree_node->menutitle}>
		</a>
		<span><{$tree_node->menutitle}></span>
<{else}>
	<li <{if $tree_node->checkActive()}>class="active"<{elseif $tree_node->node_opened}>class="open"<{/if}>>
		<a href="<{$tree_node->HURL}>" 
			title="<{$tree_node->pagetitle}>">
			<{if $img_path}><img src="<{$img_path}>/<{$tree_node->alias}>.jpg" /><{/if}>
			<{$tree_node->menutitle}>
		</a>
<{/if}>
		<{if ($tree_childrens && !$level) || ($tree_childrens && $level>$tree_paragraph)}>
			<ul class="sub_menu">
				<{show_tree tpl_path=$tpl_path tree_object=$tree_object tree_paragraph=$tree_paragraph menu_type=$menu_type img_path=$img_path}>
			</ul>
		<{/if}>
	</li>