
<{if $msg}><h4><{$msg}></h4><{/if}>

<form enctype="multipart/form-data" action="/admin/run/core/import-i18n/" method="post">

<input name="lang_file" type="file"/>
<input value="Submit" type="submit"/>

</form>