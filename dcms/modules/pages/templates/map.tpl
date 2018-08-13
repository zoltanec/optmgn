<h1>Карта сайта</h1>
<div id="sitemap">
	<ul>
		<li>
			<a href="<{$me.www}>" title="Главная">Главная</a>
		</li>
		<{show_tree tpl_path="dit:pages;map/" tree_object=Pages_Menu::getMenuTree() tree_paragraph=0}>
	</ul>
</div>