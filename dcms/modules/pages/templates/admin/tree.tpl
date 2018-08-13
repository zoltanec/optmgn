<ul class="tree_root">
	<li>
		<div class="tree_node">
			<img class="tree_toggle toggle_minus" src="<{$theme.admin.images}>/px.png" />
			<span class="root_node node active_node">Сайт</span>
		</div>
		<ul>
			<{show_tree tpl_path="dit:pages;admin/" tree_object=$tree_object tree_paragraph=$tree_paragraph}>
		</ul>
	</li>
</ul>