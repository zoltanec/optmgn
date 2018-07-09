<div id="text_content">
	<{$parent->qcontent}>
	<{foreach item=ch from=$parent->getChildren()}>
		<h4 class="faq" value="<{$ch->qid}>"><{$ch->qname}></h4>
		<p id="render" class="quest_answer answer<{$ch->qid}>"></p>
	<{/foreach}>
</div>