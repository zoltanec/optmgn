<h1>Управление параметрами меню</h1>

<form action="<{$me.path}>/add-menu-item/" method="post">
<table class="form">
 <tr>
  <td>Название меню:</td>
  <td><input type="text" name="menu_name"></td>
 </tr>

 <tr>
  <td>URI:</td>
  <td><input type="text" name="menu_uri"></td>
 </tr>

 <tr>
  <td></td>
  <td><input type="submit" class="submit_add" value="#ADD#"></td>
 </tr>
</table>
</form>

<table class="cms_list" data-list-funcs="delete active">
	<thead>
		<tr>
  			<th>Номер</th>
			<th>Название</th>
			<th>Адрес</th>
			<th>A</th>
			<th>Порядок</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>

	<{foreach item=mi from=Admin_MenuItem::getAllMenus()}>
		<tbody data-id="<{$mi->item_id}>" data-type="element" data-active="<{$mi->active}>" data-object-id="<{$mi->object_id()}>">
			<form method="post" action="<{$me.path}>/update-menu-item/">
			<tr>
  				<td class="num"><{$mi->num}></td>
  				<td>
   					<input type="hidden" name="item_id" value="<{$mi->item_id}>">
					<input type="text" name="menu_name" value="<{$mi->menu_name}>">
				</td>
  				<td><input type="text" name="menu_uri" value="<{$mi->uri}>"></td>
  				<td class="active"></td>
  				<td>
	  				<a href="<{$me.path}>/update-menu-item-priority/mode_up/itemid_<{$menu_item->item_id}>/"><img src="<{$config->cdn_images}>/admin/up.png"></a>
    				<b><{$menu_item->priority}></b>
   					<a href="<{$me.path}>/update-menu-item-priority/mode_down/itemid_<{$menu_item->item_id}>/"><img src="<{$config->cdn_images}>/admin/down.png"></a></td>
  				<td>
  					<input type="submit" name="save" class="submit_update" value="#SAVE#" />
  				</td>
  				<td class="delete"></td>
 			</tr>
 			</form>
		</tbody>
	<{/foreach}>
</table>
