<h2 class="fullhead">Комментарии к <{$news->title}></h2>
  <table class="public_info">
   <tr><td><b>Автор:</b></td><td><i><{$news->author}></i></td></tr>
   <tr><td><b>Источник:</b></td><td><{$news->source}></td></tr>
   <tr><td><b>Опубликовано:</b></td><td><i><{$news->addtime|convert_time}></i></td></tr>
   <tr><td><a href="<{$me.path}>/read/<{$t.news->nid}>/">Читать новость целиком</a></td></tr>
  </table>

 <{include object_id=$news->object_id() order_mode="reverse" form="top" file="comments;comments"}>