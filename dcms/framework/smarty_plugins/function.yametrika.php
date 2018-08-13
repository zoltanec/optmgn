<?php
//функция дергает случайную цитату из базы и сохраняем ее на некоторый период
function smarty_function_yametrika($params, &$smarty) {
	if(!isset($params['id'])) {
		return '';
	}
	$id = $params['id'];
	return "<!-- Yandex.Metrika -->\n
<script src=\"//mc.yandex.ru/metrika/watch.js\" type=\"text/javascript\"></script>
<div style=\"display:none;\"><script type=\"text/javascript\">
try { var yaCounter{$id} = new Ya.Metrika({$id}); } catch(e){}
</script></div>

<noscript><div style=\"position:absolute\"><img src=\"//mc.yandex.ru/watch/{$id}\" alt=\"\" /></div></noscript>
<!-- /Yandex.Metrika -->";
}
?>