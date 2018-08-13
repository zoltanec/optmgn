<h1>Добро пожаловать на главную страницу системы управления сайтом dCMS</h1>

<{if $user->reqRights('god')}>
<ul>
 <li><a href="<{$me.path}>/run/core/list-modules/">Список доступных модулей системы</a></li>
 <li><a href="<{$me.path}>/menu-items/">Управление меню администраторской панели</a></li>
 <li><a href="<{$me.path}>/run/core/entity.index">Управление информационными блоками</a></li>
 <li><a href="<{$me.path}>/run/core/entity.add-module">Добавление нового модуля</a></li>
</ul>
<{/if}>

