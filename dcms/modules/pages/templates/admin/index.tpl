<h1>Управление материалами сайта</h1>
<{*h2>Добавить материалы автоматом</h2>
<form id="parse_urls" method="post" action="<{$run.me}>/parse-pages/">
	<div class="form_block">
		<div class="form_row">
			<div class="label">Шаблон</div>
			   <select id="pattern" name="pattern">
					<{foreach item="patern_p" key="pattern" from=Core_Parser::$patterns}>
						<option value="<{$pattern}>">
							<{$pattern}>
						</option>
					<{/foreach}>
			   </select>
		</div>
		<div class="form_row">
			<div class="label">Родительский документ</div>
			   <select id="parent_select" name="parent_id">
					<option value="0">Сайт</option>
					<{foreach item=parent from=Pages_StaticPage::getTree()}>
						<option value="<{$parent->content_id}>"
						<{if $parent->content_id == $page->parent_id}>selected<{/if}>>
							<{textformat indent=$parent->offset indent_char="&nbsp;&nbsp;&nbsp;"}>|<{/textformat}>
							<{textformat indent=$dir->offset indent_char="-"}>-<{/textformat}>
							<{$parent->pagetitle}>
						</option>
					<{/foreach}>
			   </select>
		</div>
		<div class="form_row">
			<div class="label">Ссылки</div>
			<textarea name="urls" cols="65"></textarea>
		</div>
		<div class="form_row">
			<input type="submit" class="submit" value="#ADD#" />
		</div>
	</div>
</form*}>
<p>Активных: <{$active_total}>   Всего: <{$total}></p>
<div id="left_bar_wrap">
	<div id="left_bar">
		<div id="action_bar">
			<div class="action_bar_button" ><div id="arrow_down"></div></div>
			<div class="action_bar_button" ><div id="arrow_up"></div></div>
			<div class="action_bar_button button_offset" ><div id="add_doc"></div></div>
			<div class="action_bar_button" ><div id="copy"></div></div>
			<div class="action_bar_button" ><div id="delete_doc"></div></div>
			<div class="action_bar_button button_offset" ><div id="refresh"></div></div>
		</div>
		<div id="tree_nav">
			<{include file="pages;admin/tree.tpl"}>
		</div>
	</div>
</div>
<div id="right_info_wrap">
	<div id="right_info">
		<div id="module_info">
			<h2>Статичные материалы</h2>
			<p>
			В этом разделе вы можете управлять статичными материалами. 
			Каждый материал имеет материал-родителя, в зависимоcти
			от этого выстраиваеться дерево всех материалов в левой панели.
			</p>
			<p> 
			Материалы можно
			копировать, добавлять новые, удалять.
			Для того чтобы материал был первым в меню, списке отображения на сайте,
			необходимо выставить максимальный приоритет.
			</p>
			<p>
			Можно отключить публикацию документа соответствующей опцией при редактировании.
			</p>
			<p>
			Соответствующей опцией можно сделать, чтобы документ не отображался в главном меню сайта. 
			</p>
		</div>	
	</div>
</div>