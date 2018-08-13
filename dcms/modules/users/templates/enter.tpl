<h2 class="fullhead">Войти на сайт</h2>
<{if $req->textLine('param1')=='loginza'}>
<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
<iframe src="http://loginza.ru/api/widget?overlay=loginza&amp;lang=en&amp;token_url=<{$me.www}>/users/loginza/&providers_set=facebook,google,twitter,linkedin,vkontakte,livejournal,aol,flickr,webmoney,mailru,yandex,lastfm,verisign,steam" style="width:359px; height:190px;" scrolling="no" frameborder="no"></iframe>
<{else}>
<form action="<{$me.path}>/authorize-me/" method="post">
<table class="users_auth_form">
    <tr>
        <tr><td rowspan="3"><img src="<{$theme.images}>/login.logo.png"></td>
        <td>Логин:</td>
        <td><input type="text" name="username"></td>
    </tr>
    <tr>
        <td>Пароль:</td>
        <td><input type="password" name="password"></td>
    </tr>
    <tr>
    	<td>Запомнить меня:</td>
        <td><input type="checkbox" name="rememberme" value="1"></td>
    </tr>
    <tr>
        <td></td>
        <td><button name="submit" type="submit" class="submit_auth_button"><span>Вход</span></button></td>
    </tr>
</table>
</form>
<{/if}>