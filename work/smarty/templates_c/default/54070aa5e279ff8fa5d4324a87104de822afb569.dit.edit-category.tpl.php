<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:29:57
         compiled from "dit:store;admin/edit-category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9882986035b432b15bdf972-53644991%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54070aa5e279ff8fa5d4324a87104de822afb569' => 
    array (
      0 => 'dit:store;admin/edit-category.tpl',
      1 => 1520075627,
    ),
  ),
  'nocache_hash' => '9882986035b432b15bdf972-53644991',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_formline')) include '/home/www/kuksha/www.sportLand.ru/public_html/dcms/framework/smarty_plugins/function.formline.php';
?><form method="post" action="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/update-category/">
<input type="hidden" name="catid" value="<?php echo $_smarty_tpl->getVariable('category')->value->catid;?>
">
<table class="cms_form">
	<?php echo smarty_function_formline(array('type'=>'header'),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Название','name'=>'category_name','value'=>$_smarty_tpl->getVariable('category')->value->category_name),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Код раздела','name'=>'category_code','value'=>$_smarty_tpl->getVariable('category')->value->category_code),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Код импорта','name'=>'import_code','value'=>$_smarty_tpl->getVariable('category')->value->import_code),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Категория','type'=>'select','name'=>'category_pid','list'=>Store_Category::getAllCategories(),'with_null'=>'Корень','value'=>$_smarty_tpl->getVariable('category')->value->category_pid,'showfield'=>'category_name','field'=>'category_id'),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Активна','name'=>'active','type'=>'bool','value'=>$_smarty_tpl->getVariable('category')->value->active),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('title'=>'Спец.шаблон','name'=>'custom_tpl','type'=>'bool','value'=>$_smarty_tpl->getVariable('category')->value->custom_tpl),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('type'=>'save'),$_smarty_tpl->smarty,$_smarty_tpl);?>

</table>
</form>



<h2>Управление категориями товаров</h2>
<form method="post" action="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/add-category/">
<?php echo smarty_function_formline(array('type'=>'hidden','name'=>'cid','value'=>$_smarty_tpl->getVariable('category')->value->category_id),$_smarty_tpl->smarty,$_smarty_tpl);?>

<table class="cms_form">
	<?php echo smarty_function_formline(array('title'=>'Название','name'=>'category_name'),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php echo smarty_function_formline(array('type'=>'save'),$_smarty_tpl->smarty,$_smarty_tpl);?>

</table>
<table class="cms_list" data-list-funcs="delete active edit fields">
	<thead>
	<tr>
		<th><b>№</b></th>
		<th><b>Название категории</b></th>
		<th>A</th>
		<th><b>Приоритет</b></th>

		<th colspan="3"><b>Функции</b></th>
	</tr>
	</thead>
	<?php  $_smarty_tpl->tpl_vars['subcategory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->categories; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->key => $_smarty_tpl->tpl_vars['subcategory']->value){
?>
	<tbody data-type="element" data-id="<?php echo $_smarty_tpl->getVariable('subcategory')->value->nid;?>
" data-active="<?php echo $_smarty_tpl->getVariable('subcategory')->value->active;?>
" data-object-id="<?php echo $_smarty_tpl->getVariable('subcategory')->value->object_id();?>
">
		<tr>
			<td><?php echo $_smarty_tpl->getVariable('subcategory')->value->category_id;?>
</td>
			<td align="center">
				<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/edit-category/catid_<?php echo $_smarty_tpl->getVariable('subcategory')->value->category_id;?>
/"><?php echo $_smarty_tpl->getVariable('subcategory')->value->category_name;?>
</a>
			</td>

			<td class="active"></td>

			<td data-field="priority" class="priority">
	    		<a class="up" title="Повысить" data-field-func="inc"></a>
				<b data-field-func="value"><?php echo $_smarty_tpl->getVariable('subcategory')->value->priority;?>
</b>
				<a class="down" title="Понизить" data-field-func="dec"></a>
   			</td>

			<td class="edit" data-url="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/edit-category/catid_<?php echo $_smarty_tpl->getVariable('subcategory')->value->subcategory_id;?>
/"></td>
			<td class="delete"></td>
			</tr>
	</tbody>
	<?php }} ?>
</table>

<h2>Поля</h2>
<table class="cms_list">
	<?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->fields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value){
?>
		<?php echo smarty_function_formline(array('title'=>'Код','name'=>'code','value'=>$_smarty_tpl->getVariable('field')->value->code),$_smarty_tpl->smarty,$_smarty_tpl);?>

		<?php echo smarty_function_formline(array('title'=>'Тип','name'=>'ptype','value'=>$_smarty_tpl->getVariable('field')->value->ptype),$_smarty_tpl->smarty,$_smarty_tpl);?>

	<?php }} ?>
</table>


<h2>Товары</h2>

<table class="cms_list" data-list-funcs="delete active edit fields">
	<thead>
		<tr>
			<th><b>N/b></th>
			<th>Фото</th>
			<th>Название</th>
			<th>Цена</th>
			<th>А</th>
			<th>Приоритет</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>
<?php  $_smarty_tpl->tpl_vars['prod'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['prod']->key => $_smarty_tpl->tpl_vars['prod']->value){
?>
	<tbody data-type="element" data-id="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
" data-active="<?php echo $_smarty_tpl->getVariable('prod')->value->active;?>
" data-object-id="<?php echo $_smarty_tpl->getVariable('prod')->value->object_id();?>
">
		<tr>
			<td class="center"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
</td>
			<td class="center"><img width="90" src="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
" /></td>
			<td><a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/edit-product/pid_<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</a></td>
			<td class="center"><?php echo $_smarty_tpl->getVariable('prod')->value->price;?>
 руб.</td>
			<td class="active"></td>
			<td data-field="priority" class="priority">
	    		<a class="up" title="Повысить" data-field-func="inc"></a>
				<b data-field-func="value"><?php echo $_smarty_tpl->getVariable('prod')->value->priority;?>
</b>
				<a class="down" title="Понизить" data-field-func="dec"></a>
   			</td>
   			<td class="edit" data-url="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/edit-product/pid_<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/"></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<?php }} ?>
</table>
