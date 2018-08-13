<h1>Отправить сообщение</h1>
<{assign var="conf" value=D_Core_Factory::Feedback_Feedback(1)}>
<form id="postmsg" method="post" action=""><label for="name"><span class="required">*</span> Ваше имя:</label><br />
<input name="name" type="text" size="40" /><br />
<label for="email"><span class="required">*</span>
Электронная почта:</label><br />
<input name="email" type="text" size="40" /><br />
<{if $conf->phone==1}>
<label for="telephone">Контактный телефон (факс):</label><br />
<input name="telephone" type="text" size="40" /><br />
<{/if}>
<{if $conf->company==1}>
<label for="company">Компания:</label><br />
<input name="company" type="text" size="40" /><br />
<{/if}>
<{if $conf->country==1}>
<label for="country">Страна:</label><br />
<select name="country">
<option value="0">Выберите страну</option>
	<{foreach item=country from=Feedback_Feedback::getCountries()}>
	<option value="<{$country.country_id}>"><{$country.name}></option>
	<{/foreach}>
</select><br />
<{/if}>
<{if $conf->region==1}>
<label for="region">Регион:</label><br />
<select name="region" <{if $conf->country==1}>disabled="disabled"<{/if}>>
	<option value="0">Выберите регион</option>
	<{foreach item=region from=Feedback::getRegions()}>
	<option value="<{$region.region_id}>"><{$region.name}></option>
	<{/foreach}>
</select><br />
<label for="city">Город:</label><br />
<select name="city" disabled>
	<option value="0">Выберите город</option>
</select><br />
<{/if}>
<{if $conf->depart==1}>
<label for="department">Департамент:</label><br />
<select name="department">
	<{foreach item=depart from=Feedback_Feedback::getDeparts()}>
	<option value="<{$depart.did}>"><{$depart.dep_name}></option>
	<{/foreach}>
</select><br />
<{/if}>
<{if $conf->cause==1}>
<label for="cause">Причина обращения:</label><br />
<select name="cause">
	<{foreach item=cause from=$conf->getCauses()}>
	<option value="<{$cause.csid}>"><{$cause.csname}></option>
	<{/foreach}>
</select><br />
<{/if}>
<label for="content"><span class="required">*</span> Текст
сообщения:</label><br />
<textarea id="sendmessage" name="content" rows="8" cols="55"></textarea><br />
<br />
<{if $conf->know==1}>
<label for="how_know">Как вы узнали о нас?</label><br />
<select name="know">
	<{foreach item=reply from=$conf->getReply()}>
	<option value="<{$reply.rid}>"><{$reply.rname}></option>
	<{/foreach}>
</select><br />
<{/if}>
<{if $conf->subscribe==1}>
<label for="news">Подписаться на рассылку новостей:</label><br />
<input name="subscribe" type="checkbox" value="1" /><br />
<{/if}>
<label>Проверочная картинка:</label><br />
<img class="captcha" name="captcha1"  src="<{$me.path}>/captcha" ><br />
<label>Код с картинки:</label><br />
<input type="text" name="captcha" /><br />
<input class="submit" type="submit" value="#SEND#" /></form>
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
	$("#postmsg input[type='submit']").click(sendmessage);
	function sendmessage() {
	          var name = $("input[name='name']").val();
	          var email = $("input[name='email']").val();
			  var telephone = $("input[name='telephone']").val();
			  var company = $("input[name='company']").val();
			  var country = $("select[name='country']").val();
			  var region = $("select[name='region']").val();
			  var city = $("select[name='city']").val();
			  var depart = $("select[name='department']").val();
			  var cause = $("select[name='cause']").val();
			  var know = $("select[name='know']").val();
			  if ($("input[name='subscribe']").is(":checked")) {
			  	var subscribe = $("input[name='subscribe']").val();
			  }else {
			      var subscribe=0;
			  }
			  var content = $("#sendmessage").val();
			  var captcha = $("input[name='captcha']").val();
			  if (name=='' || email=='' || content=='')
			  {
			      alert("Заполните обязательные поля, отмеченные символом * !");
			  }
			  else {
				  	var reg=/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;
					if(!reg.test(email)){
					    alert("Пожалуйста, введите свой настоящий e-mail");
					} else {
				          		$.ajax({
									type: "POST",
									url: "<{$me.www}>/feedback/send-message",
									data: 'captcha='+captcha+'&name='+name+'&phone='+telephone+'&email='+email+'&company='+company+'&country_id='+country+'&region_id='+region+'&city_id='+city+'&did='+depart+'&csid='+cause+'&rid='+know+'&subscribe='+subscribe+'&content='+content,
									success: function(html){
										if (html=='wrong_code') {
										    alert("Вы ввели неправильный код с картинки!");
										} else {
										    alert("Сообщение отправлено!");
										    $("img.captcha").attr("src", '<{$me.path}>/captcha/'+Math.random());

										}
									}
								});
							}
					}
			  return false;
	   }
});
</script>
