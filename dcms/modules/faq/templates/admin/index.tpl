<script type="text/javascript">
$(document).ready(function(){
	$("#browser").treeview({
			persist: "location",
			collapsed: true,
			unique: true
		});
	$(".filetree a").click(function(){
		var qid=$(this).attr("id");
		$(".filetree a").removeClass("active");
		$(this).addClass("active");
		if (!$(this).hasClass("root"))
		$.ajax({
			type: "POST",
			url: "<{$t.run.me}>/view-doc",
			data: 'qid='+qid,
			success: function(data){
				$("div#view").html(data);
		   }
		});
		return false;
	});
	$(".control a").click(function(){
	    var lnk=$(this).attr("href");
	    var qid=$(".filetree a.active").attr("id");
	    if (!qid || (qid==0 && !$(this).hasClass("add_link"))) {
		    alert("Выберите нужный документ!");
	    } else {
		if ($(this).attr("class")=='delete_link') {
		    if(!confirm("Вы действительно хотите удалить данный документ и все его дочерние документы?")) {
			return false;
		}
		else {
		   	$(this).attr("href",$(this).attr("href")+'qid_'+qid);
		   	return true;
		}
		} else {
	    $.ajax({
			type: "POST",
			url: lnk,
			data: 'qid='+qid,
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
<h2>Управление разделом вопросы-ответы</h2>
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
		<td><{$filetree}></td>
	</tr>
	</table>
</div>
<div id="view">
<form method="post" action="<{$run.me}>/submit-doc/">
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавление нового документа<b/></td>
	</tr>
	<tr>
		<td>Название документа<input type="hidden" name="pid" value="0" /></td>
		<td><input type="text" name="qname" size="82" /></td>
	</tr>
	<tr>
		<td>Содержимое документа</td>
		<td><textarea id="rich" rows="25" cols="94" name="qcontent"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>
</div>