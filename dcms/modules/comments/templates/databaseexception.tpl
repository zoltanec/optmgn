<{foreach item=line from=$t.e->getTrace()}>
	<{$line.file}>:<{$line.line}>
<{/foreach}>