<form id="postmsg" class="question" method="post" action="<{$me.www}>/feedback/send-message">
<div class="comt_inp_title">Напишите нам ваши отзывы и предложения</div>
  <textarea id="sendmessage" name="content"></textarea>
  <div class="button"><div><span>Отправить</span></div></div>
</form>
<script type="text/javascript" src="<{$me.www}>/jscripts/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#postmsg .button').click(function() {
		var content = $("#sendmessage").val();
		if (content==''){
				alert("Заполните текстовое поле!");
				return false;
			}
    	$.post($('#postmsg').attr('action'),{'content':content},function(answer){
			if(answer!='wrong_code'){
				alert('Спасибо за то, что оставили свой отзыв!');
			}else alert('Произошла ошибка!');
		});
    	return false;
  	}); 

});
</script>