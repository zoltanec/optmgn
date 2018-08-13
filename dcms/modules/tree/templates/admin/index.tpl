<script type="text/javascript">
$(document).ready(function(){
	$("#browser").treeview({
			persist: "location",
			collapsed: true,
			unique: true
		});
	$(".filetree a").click(function(){
		var did=$(this).attr("id");
		$(".filetree a").removeClass("active");
		$(this).addClass("active");
		if (!$(this).hasClass("root"))
		$.ajax({
			type: "POST",
			url: "<{$t.run.me}>/view-doc",
			data: 'did='+did,
			success: function(data){
				$("div#view").html(data);
		   }
		});
		return false;
	});
	$(".control a").click(function(){
	    var lnk=$(this).attr("href");
	    var did=$(".filetree a.active").attr("id");
	    if (!did || (did==0 && !$(this).hasClass("add_link"))) {
		    alert("Выберите нужный документ!");
	    } else {
			if ($(this).attr("class")=='delete_link') {
				if(!confirm("Вы действительно хотите удалить данный документ и все его дочерние документы?")) {
					return false;
				}
				else {
				   	$(this).attr("href",$(this).attr("href")+'did_'+did);
				   	return true;
				}
			} else {
				    $.ajax({
						type: "POST",
						url: lnk,
						data: 'did='+did,
						success: function(data){
							$("div#view").html(data);
				  		}
					}); 
			}
	    }
	    return false;
	});
});
</script>
<h2>Управление деревом документов</h2>
<div id="tree">
	<table>
	<tr>
		<td><b>Дерево документов</b></td>
	</tr>
	<tr class="control">
		<td><a class="edit_link" href="<{$run.me}>/list-doc/">#EDIT#</a>
		<a class="delete_link" href="<{$run.me}>/delete-doc/">#DELETE#</a>
		<a class="add_link" href="<{$run.me}>/add-doc/">#ADD#</a></td>
	</tr>
	<tr>
		<td><{$df}></td>
	</tr>
	</table>
</div>
<div id="view">
<table class="form">
	<tr>
		<td colspan="2"><b>Добавление нового корневого документа<b/></td>
	</tr>
	<tr>
		<form method="post" action="<{$run.me}>/submit-doc/">
		<td>Название документа</td>
		<td><input type="text" name="dname" size="82" /></td>
	</tr>
		<tr>
		<td>Приоритет показа:
		</td>
		<td>
			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',++num); $(this).next('b').html(num++); return false;">
				<img src="<{$config->cdn_images}>/admin/up.png">
			</a>
    		<b>0</b>
   			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',--num); $(this).prev('b').html(num--); return false;">
   				<img src="<{$config->cdn_images}>/admin/down.png">
   			</a>
   			<input id="priority" type="hidden" name="priority" value="0"/>
   		</td>
	</tr>
	<tr>
		<td colspan="2"><b>Содержимое документа</b></td>
	</tr>
	<tr>
		<td colspan="2"><textarea id="rich" name="dcontent" style="width:100%; height:350px; overflow-y:auto;"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input class="submit_add" type="submit" value="#ADD#" />
		</form>
		</td>
	</tr>
</table>
<{*table class="list">
	<tr>
		<td><b>Номер документа</b></td>
		<td><b>Название документа</b></td>
		<td><b>Функции</b></td>
	</tr>
	<{foreach item=doc from=Tree::getByPid(0)}>
	<tr>
		<td><b><{$doc->did}></b></td>
		<td><{$doc->dname}></td>
		<td><a class="edit_link" href="<{$run.me}>/list-doc/did_<{$doc->did}>/">#EDIT#</a>
		<a class="delete_link" href="<{$run.me}>/delete-doc/did_<{$doc->did}>/">#DELETE#</a>
	</tr>
	<{/foreach}>
</table*}>
</div>