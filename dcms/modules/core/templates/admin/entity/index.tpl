<h2>Управление инфоблоками</h2>
<form action="<{$run.admin}>/core/entity.submit-block" method="post" enctype="multipart/form-data" >
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавить инфоблок</b></td>
	</tr>
	<tr>
		<td>Модуль</td>
		<td>
			<select id="module_name" name="module_name">
				<option value="">Выберите модуль</option>
				<option value="newmodule">Новый модуль</option>
				<{foreach item=module from=D::getModulesList()}>
					<option value="<{$module.code}>"><{$module.code}></option>
				<{/foreach}>
			</select>
			<input id="module_name" type="text" value="newmodule" />
		</td>
	</tr>
	<tr>
		<td>Класс</td>
		<td>
			<input type="text" name="class_name" value="module_classname" />
		</td>
	</tr>
	<tr>
		<td>
			Наследование
		</td>
		<td>
			<select id="class_name" name="parent_class_name" disabled="disabled">
				<option value="0">Не наследовать</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Категория</td>
		<td>
			<select id="sid" name="pid">
				<option value="0">Корневой раздел</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Описание</td>
		<td>
			<textarea name="descr" cols="40" rows="2"></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>
<h2>Редактирование инфоблоков</h2>
<table class="cms_list">
	<thead>
	<tr>
		<th><b>#</b></th>
		<th><b>Модуль</b></th>
		<th><b>Класс</b></th>
		<th><b>Наследование</b></th>
		<th><b>Родительская категория</b></th>
		<th><b>Описание</b></th>
		<th><b>Функции</b></th>
	</tr>
	</thead>
	<{foreach item=iblock from=Core_Entity_iBlock::getAllBlocks()}>
	<tbody>
		<form action="<{$run.admin}>/core/entity.update-block/blockid_<{$iblock->block_id}>" method="post">
		<tr>
			<td><{$iblock->block_id}></td>
			<td align="center">	
				<{$iblock->module_name}>
			</td>
			<td align="center">	
				<{$iblock->class_name}>
			</td>
			<td align="center">	
				<{$iblock->parent_class_name}>
			</td>
			<td class="center">
				<select name="sid">
				<option value="0">Корневой раздел</option>
				<{foreach item=section from=Core_Sections_Section::getAllSections($iblock->module_name)}>
						<option value="<{$section->sid}>" <{if $section->sid==$iblock->sid}>selected="selected"<{/if}>>
							<{$section->section_name}>
						</option>
				<{/foreach}>
				</select>
			</td>
			<td class="center">
				<textarea name="desc" cols="40" rows="2"><{$iblock->descr}></textarea>
			</td>
			<td align="center">
				<input class="submit_update" type="submit" name="save" value="Сохранить" />
				<input class="submit_delete" type="submit" name="delete" value="Удалить" />
				<a href="<{$run.me}>/entity.add-properties/blockid_<{$iblock->block_id}>"><input type="button" name="edit" value="Правка полей" /></a>
				<a href="<{$run.me}>/entity.gen-model/blockid_<{$iblock->block_id}>"><input type="button" name="edit" value="Генерировать" /></a>
			</td>
		</tr>
	</form>	
	</tbody>
	<{/foreach}>
</table>
<script type="text/javascript">
	$("input#module_name").hide();
	$("input#module_name").change(function(){
		$("select#module_name option:selected").attr("value",$(this).val());
		return false;
	});
	$("select#module_name").change(function(){
		if($(this).val()){
			$("input[type=submit]").removeAttr("disabled");
			if($(this).val()=="newmodule"){
				$("input#module_name").show();
				$("select#class_name").attr("disabled","disabled");
			}else {
				$("input#module_name").hide();
				$("select#class_name").html("");
				$("select#class_name").append("<option value='0'>Не наследовать класс</option>");
				$.getJSON("<{$run.admin}>/core/entity.get-classes/module_"+$(this).val(),function(answer){
					$.each(answer,function(item,module_class){
						if(answer){
							$("select#class_name").removeAttr("disabled");
							$("select#class_name").append("<option value="+module_class+">"+module_class+"</option>");
						} else $("select#class_name").attr("disabled","disabled");
					});
				});
			}
		}else {
			$("input#module_name").hide();
			$("input[type=submit]").attr("disabled","disabled");
		}
		return false;
	});
	$("select#class_name").change(function(){
		if($(this).val())
			$.getJSON("<{$run.admin}>/core/entity.get-sections/class_"+$(this).val(),function(answer){
				if(answer){
					$("select#section_pid").removeAttr("disabled");
					$("select#section_pid").html("");
					$("select#section_pid").append("<option value=0>Корневой раздел</option>");
					$.each(answer,function(item,section){
						$("select#section_pid").append("<option value="+section.sid+">"+section.section_name+"</option>");
					});
				}else $("select#section_pid").attr("disabled","disabled");
			});
		return false;
	});
	
</script>
