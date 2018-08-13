	<p><{$parent->dcontent}></p>
	<{foreach item=ch from=$parent->getChildren()}>
		<h4 class="doc" value="<{$ch->did}>" title="<{mb_strtolower($ch->dname)}>"><{$ch->dname}></h4>
		<p class="doc_cont"></p>
	<{/foreach}>