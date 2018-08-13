Error: C<{$t.e->getCode()}><br>
Exception: <{$t.e->getMessage()}>

<div class="cms_exception_dump">
<{if method_exists($e,'renderTrace')}>
	<{$e->renderTrace()}>
<{else}>
	<{var_dump($e)}>
<{/if}>
</div>