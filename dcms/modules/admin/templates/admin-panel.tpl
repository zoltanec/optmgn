<{css file='admin/panel.css'}>
<{javascript file='admin.functions.js'}>
<div id="cms_admin_panel_open">
 <a id="cms_to_admin_open" href="#"><img src="<{$theme.images}>/admin/admin_bg.png" /></a>
   <div id="cms_right_open">
   <div id="cms_hide_open">Свернуть</div>
  </div>
  <form id="cms_flush_cache" method="post" action="<{$req->current_url}>">
	<{foreach item=post_var_value key=post_var_name from=$req->_POST}>
	<input type="hidden" name="<{$post_var_name}>" value="<{$post_var_value}>">
	<{/foreach}>
	<input type="hidden" name="flush_cache" value="Y">
  </form>
  <div id="cms_buttons_wrap">
   <div class="cms_button"><div id="cms_panel_btn_cache"><span>Сбросить <br />кеш</span></div></div>
   <div class="cms_button"><div id="cms_btn_sql"><span>Запрос SQL</span></div></div>
   <div class="cms_button"><div id="cms_btn_shabl"><span>Шаблоны</span></div></div>
   <div class="cms_button"><div id="cms_btn_red"><span>Редактиро-<br />вать</span></div></div>
   <div class="cms_button"><div id="cms_btn_del"><span>Удалить страницу</span></div></div>
  </div>
</div>
<script type="text/javascript">
D.modules.admin.bind_admin_panel();
</script>