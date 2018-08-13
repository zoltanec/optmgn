<{if $req->action=='question'}>
<h1>Зайдайте вопрос</h1>
<form id="postmsg" class="question" method="post" action="<{$me.www}>/feedback/send-message-partners">
<table class="send_message_input" style="max-width:682px">

	<tr>
		<td>Контактный e-mail* &nbsp;</td>
		<td><input name="email" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Сообщение </td>
		<td><textarea id="sendmessage" name="content" rows="8" cols="40"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="right orange submit" type="submit" value="Отправить" /></td>
	</tr>	
</table>
</form><div style="display:none" id="output"></div>
<{elseif $req->action=='partners'}>
<h1>Заявка в партнеры</h1>
<form id="postmsg" class="partners" method="post" action="<{$me.www}>/feedback/send-message-partners">
<table class="send_message_input" style="max-width:682px">
	<tr>
		<td>Вид сотрудничества*</td>
		<td>
			<select name="partnership">
				<option value="">Выберите вариант</option>
				<option value="Дистрибьютор">Дистрибьютор</option>
				<option value="Дилер">Дилер</option>
				<option value="Партнер">Партнер</option>
				<option value="Агент">Агент</option>
			</select>
		</td>
	</tr>	
		<tr>
		<td>Название*</td>
		<td><input name="org_name" type="text" size="40" />
			<select name="org_type">
				<option value="">Выберите вариант</option>
				<option value="Организация">Организация</option>
				<option value="ИП">ИП</option>
				<option value="Физическое лицо">Физическое лицо</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Контактное  лицо*</td>
		<td><input name="name" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Контактный e-mail*</td>
		<td><input name="email" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Контактный  телефон*</td>
		<td><input name="phone" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Ваш сайт</td>
		<td><input name="sitename" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Регион в котором планируете работать*</td>
		<td><input name="region" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Опыт работы (количество лет)</td>
		<td><input name="experience" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Наличие собственных строительных бригад</td>
		<td>
			<input name="brigade" type="radio" value="Да" checked="checked"/> Да<br />
			<input name="brigade" type="radio" value="Нет"/> Нет
		</td>
	</tr>
	<tr>
		<td>Возможности вашего предприятия и планы продвижения продукта</td>
		<td><textarea id="sendmessage" name="content" rows="8" cols="40"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="right orange submit" type="submit" value="Отправить" /></td>
	</tr>	
</table>
</form><div style="display:none" id="output"></div>
<{else}>
<h1>Заказ фундамента</h1>
  <{*div id="calc"><img src="<{$theme.images}>/calc.png"><a class="big_ln right" href="">рассчитать фундамент</a></div>
  <div class="right">
	<img src="<{$theme.images}>/operator.png" /><br />
	<a class="big_ln right" href="">Заказать звонок</a> 
</div*}>
<{assign var="conf" value=D_Core_Factory::Feedback_Feedback(1)}>
<form id="postmsg" method="post" action="<{$me.www}>/feedback/send-message">
<input type='hidden' name='result' value='<{$result}>' />
<input type='hidden' name='piles' value='<{$piles}>' />
<table class="send_message_input">
	<tr>
		<td width="200">Ф.И.О </td>
		<td><input name="name" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>E-mail</td>
		<td><input name="email" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Телефон</td>
		<td><input name="phone" type="text" size="40" /></td>
	</tr>
	<tr>
		<td>Описание объекта</td>
		<td><textarea id="sendmessage" name="content" rows="8" cols="40"></textarea></td>
	</tr>
	<tr>
		<td>Прикрепить файл<br /><span class="small">(Word, JPEG, TIFF)</span></td>
		<td><input type="file" name="attachment[]" class="multi" /></td>
	</tr>
	<{if $conf->know==1}>
	<tr>
		<td>Как вы узнали о нас?</td>
		<td><select name="know">
				<option value="">Выберите вариант</option>
				<{foreach item=reply from=$conf->getReply()}>
					<option value="<{$reply.rname}>"><{$reply.rname}></option>
				<{/foreach}>
			</select>
		</td>
	</tr>
	<{/if}>
	<tr>
		<td></td>
		<td><input class="right orange submit" type="submit" value="Отправить" /></td>
	</tr>	
</table>
<{*p>
Заполните — <a href="">опросный лист клиента</a> помогите улучшить наше с вами сотрудничество.
</p*}>
</form>
<div style="display:none" id="output"></div>
<{/if}>
<script type="text/javascript" src="<{$me.www}>/jscripts/jquery.MultiFile.js"></script>
<script type="text/javascript" src="<{$me.www}>/jscripts/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("img.captcha").css('cursor','pointer');
    $("img.captcha").click(function(){
		   $("img.captcha").attr("src", '<{$me.path}>/captcha/'+Math.random());
	    });

	$("select[name=country]").bind('change',function(){
		if($("select[name=country]").val()!=0) {
            $("select[name=region]").attr('disabled','');
            var cid = $("select[name=country]").val();
            $.getJSON("<{$me.www}>/feedback/getregions/cid_"+cid, function(data){
            	$("select[name=region]").html("");
            	$("select[name=region]").append("<option value='0'>Выберите регион</option>");
            	$.each(data, function(i, item){
            		$("select[name=region]").append("<option value="+item.region_id+">"+item.name+"</option>");
            	});
            });
		} else {
			$("select[name=region]").attr("disabled", "disabled");
			$("select[name=city]").attr("disabled", "disabled");
		}
	});
	$("select[name=region]").bind('change',function(){
		if($("select[name=region]").val() != '0') {
            $("select[name=city]").attr('disabled','');
            var rid = $("select[name=region]").val();
            $.getJSON("<{$me.www}>/feedback/getcities/rid_"+rid, function(data){
            	$("select[name=city]").html("");
            	$("select[name=city]").append("<option value='0'>Выберите город</option>");
            	$.each(data, function(i, item){
            		$("select[name=city]").append("<option value="+item.city_id+">"+item.name+"</option>");
            	});
            });
		} else {
			$("select[name=city]").attr('disabled', 'disabled');
		}
	});
	var options = {
		target: "#output",
		beforeSubmit: Request,
        success: Response,
		timeout: 10000
	};
	$('#postmsg').submit(function() {
    	$(this).ajaxSubmit(options);
    	return false;
  	}); 
	function Request(formData, jqForm, options){ 
    		var queryString = $.param(formData);
			var name = $("input[name='name']").val();
	        var email = $("input[name='email']").val();
			var telephone = $("input[name='telephone']").val();
			var content = $("#sendmessage").val();
			if($('#postmsg').hasClass('partners')){
				var partnership = $("select[name='partnership']").val();
				var org_name = $("input[name='org_name']").val();
				var org_type = $("select[name='org_type']").val();
				var region = $("input[name='region']").val();
				if (name=='' || email=='' || partnership=='' || telephone=='' || org_name=='' || org_type=='' || region==''){
					alert("Заполните все обязательные поля!");
				}else {
					var reg=/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;
					if(!reg.test(email)){
						alert("Пожалуйста, введите свой настоящий e-mail");
					} else {
					   return true; 
					}
				}
			}else if($('#postmsg').hasClass('question')){
				if (email=='' || content==''){
					alert("Заполните все обязательные поля!");
				}else {
					var reg=/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;
					if(!reg.test(email)){
						alert("Пожалуйста, введите свой настоящий e-mail");
					} else {
					   return true; 
					}
				}
			}else{
				var know=$("select[name=know]").val();
				if (name=='' || email=='' || content=='' || telephone=='' || know==''){
					alert("Заполните все обязательные поля!");
				}else {
					var reg=/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;
					if(!reg.test(email)){
						alert("Пожалуйста, введите свой настоящий e-mail");
					} else {
					   return true; 
					}
				}
			}
    		return false;
	};
	function Response(responseText, statusText){
		if(responseText!='wrong_code'){
			alert('Спасибо за обращение в компанию ГлавФундамент. <{if $req->action!='partners'}>Специалист компании свяжется с Вами в течение 24 часов.<{elseif $req->action=='question'}>Ваш вопрос принят к рассмотрению<{else}>Специалист корпоративного отдела свяжется с Вами в течение 24 часов.<{/if}>');
			location.href='<{$me.www}>/pages/clients';
		}else alert('Произошла ошибка!');
		$('#output').html('');
	};
});
</script>