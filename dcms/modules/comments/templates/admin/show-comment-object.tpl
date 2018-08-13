<h2>Информация об объекте комментирования</h2>

<table class="list">
 <tr>
  <td>Путь объекта:</td>
  <td><{$object->object_id}></td>
 </tr>

 <tr>
  <td>Количество сообщений:</td>
  <td><{$object->object_hash}></td>
 </tr>

 <tr>
  <td>Время первого комментария:</td>
  <td><{$object->first|convert_time}></td>
 </tr>

 <tr>
  <td>Всего сообщений:</td>
  <td><{$object->count}></td>
 </tr>

 <tr>
  <td>Шаблон отображения:</td>
  <td><input type="text" name="template" value="<{$object->template}>"></td>
 </tr>

 <tr>
  <td>Режим премодерации:</td>
  <td><input value="1" type="checkbox"<{if $object->premoderate}> checked<{/if}>></td>
 </tr>

 <tr>
  <td></td>
  <td><input type="submit" class="submit submit_update" value="#SAVE#"></td>
 </tr>
</table>