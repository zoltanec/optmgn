<ul class="nav">
	<{if !$parent_id}>
		<li <{if Pages_Menu::isMainActive()}>class="active"<{/if}>>
			<a href="<{$me.www}>" title="Главная">Главная</a>
			<{if $menu_type=='vertical'}><span>Главная</span><{/if}>
		</li>
	<{/if}>
	<{show_tree module='pages' 
						tpl_path="dit:pages;" 
						tree_object=Pages_Menu::getMenuTree($parent_id) 
						tree_paragraph=0 
						menu_type=$menu_type 
						level=$level  
						img_path=$img_path}>
</ul>