<{$parent->qcontent}>
<ul class="text_cont_list">
	<{foreach item=ch from=$parent->getChildren()}>
		<li><a class="text_big_link" href="#" data-qid="<{$ch->qid}>"><{$ch->qname}></a>
		<div class="text_content"></div>
	<{/foreach}>
</ul>