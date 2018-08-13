<{if is_object($e)}>
	<{if method_exists($e,'getMessage')}>
		<{$e->getMessage()}>
	<{/if}>
<{/if}>