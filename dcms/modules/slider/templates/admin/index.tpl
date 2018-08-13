<h2>Управление слайдшоу</h2>
<form method="post" action="<{$run.me}>/add-slide/">
    <table class="cms_form">
        <tr><td><strong>Добавить слайд</strong></td><td></td></tr>
        <tr><td>Заголовок:</td><td><input type="text" name="title" size="40"></td></tr>
        <tr><td>Короткое описание:</td><td><input type="text" name="short" size="60"></td></tr>
        <tr><td>URL:</td><td><input type="text" name="url" size="60"></td></tr>
        <tr><td colspan="2"><input type="submit" class="submit" value="Добавить"></td></tr>
    </table>
</form>
<script>
function deleteSlide(ssid) {
	if(confirm("Вы уверены что хотите удалить слайд?")) {
		$.getJSON('<{$run.me}>/delete-slideshow/ssid_' + ssid, function(answer) {
			$('#ssid' + ssid).remove();
		});
		return false;
	} else {
		return false;
	}
}
</script>
<h2>Список слайдов</h2>
<table class="cms_form">
 <{foreach item=slide from=Slider_Slideshow::getAllSlides()}>
   <form action="<{$run.me}>/update-slide/ssid_<{$slide->ssid}>/" enctype="multipart/form-data" method="post">
      <tr>
          <td rowspan="9"><b><{$slide->ssid}></b></td>
          <td><img width="240" src="<{$run.my_content}>/slides/<{$slide->image}>" /></td>
          <td></td>
      </tr>
      </tr>
          <td>Заголовок:</td>
          <td><input type="text" name="title" size="50" value="<{$slide->title}>"></td>
      </tr>
      <tr>
          <td>Короткое описание:</td>
          <td><input type="text" name="short" size="50" value="<{$slide->short}>"></td>
      </tr>
      <tr>
          <td>URL:</td>
          <td><input type="text" name="url" size="50" value="<{$slide->url}>"></td>
      </tr>
      <tr>
        <td>Порядок сортировки:<br><sup>Большее число всплывает наверх</sup></td>
        <td><input type="text" name="sort" value="<{$slide->sort}>"></td>
      </tr>
      <tr>
        <td>Видео-слайд:</td>
        <td><input type="checkbox" name="video" <{if $slide->video}>checked<{/if}>></td>
      </tr>

      <tr>
        <td>Слайд активен:</td>
        <td><input type="checkbox" name="active" <{if $slide->active}>checked<{/if}>></td>
      </tr>
      <tr>
        <td>Новая картинка:<br><sub>Размер 620x403</sub></td>
        <td><input type="file" name="image"></td>
      </tr>
      <tr>
        <td></td><td><input type="submit" class="submit" value="Сохранить">
            <button class="submit" onclick='return deleteSlide("<{$slide->ssid}>");'>Удалить</button>
        </td>
      </tr>
   </form>
  <{/foreach}>
</table>