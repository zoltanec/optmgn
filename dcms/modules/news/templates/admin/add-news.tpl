<form method="post" action="<{$tpl.run.me}>/submit-news/">
<table class="form">
 <tr class="form_head">
  <td colspan="2">Добавить новость</td>
 </tr>
 <tr>
  <td>Заголовок новости:</td>
  <td><input type="text" name="title" value="<{$tpl.thisnews->title|escape}>"></td>
 </tr>
 <tr>
  <td>Раздел:</td>
  <td><select name="sid">
        <{foreach item=section from=$tpl.sections}>
            <option value="<{$section.sid}>"><{$section.section_name}>
        <{/foreach}>
      </select>
  <tr>
    <td>Тэги:</td>
    <td><input type="text name="tags" value="<{$tpl.thisnews->tags|escape}>"></td>
  </tr>
  <tr>
   <td>Источник:</td>
   <td><input type="text" name="source"></td>
 </tr>
 <tr>
 	<td>Опубликовать новость:</td>
 	<td><input type="checkbox" value="1">
 </td>
 <tr>
 	<td>Режим сохранения:</td>
 	<td><select name="mode">
 		<option value="html">HTML
 	</select>
    </td>
  </tr>

  <tr>
   <td>Автор:</td>
   <td><input type="text" name="author"></td>
 </tr>
 <tr>
  <td>Новость</td>
  <td><textarea id="rich" rows="25" cols="100" name="content"><{$tpl.thisnews->content|escape}></textarea></td>
 </tr>
 <tr>
  <td colspan="2"><input class="add" type="submit" value="Добавить">
 </tr>
</table>
</form>