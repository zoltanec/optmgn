<?php
//плагин для обработки BB кодов
function smarty_modifier_bbcode($text) {
	return D_Misc_Text::bbParse($text);
	/*$from = array('/\[\[(.*)\]\]: #(\d+)/','/<img src="\{SMILES_PATH\}\/icon_(.*).gif" (.*) \/>/');
	$to = array('[b]\1[/b] #\2','http://www.metallurg.ru/themes/smiles/\1');
	//<!-- s:D --><img src="{SMILIES_PATH}/icon_biggrin.gif" alt=":D" title="Very Happy" /><!-- s:D -->
	$text = preg_replace($from,$to,$text);
	$bb = new bbcode($text);
	return $bb->get_html();*/
	/*
   $from = array('/\[\[(.*)\]\]: #(\d+)/',
   "/#(\d+)/","/\n/","/\[br\]/",'/\[p\](.*?)\[\/p\]/s',
   '/(\[b\])(.*?)\[\/b\]/i','/(\[u\])(.*?)\[\/u\]/i',
   '/\[i\](.*?)\[\/i\]/','/\[img\]((http|https):\/\/[a-zA-Z0-9\/\.\_\-\+]+)\[\/img\]/',
   '/\[url\]((http|https):\/\/[a-zA-Z0-9\/\.\_\-\+]+)\[\/url\]/',
   '/\[table\](.*?)\[\/table\]/',
   '/\[tr](.*?)\[\/tr\]/',
   '/\[td\](.*?)\[\/td\]/',
   '/\[ul\](.*?)\[\/ul\]/',
   '/\[ol\](.*?)\[\/ol\]/',
   '/\[li\](.*?)\[\/li\]/',
   '/\[url=(.+?)\](.+?)\[\/url\]/'
   );
   //шаблоны замены
   $to = array(
   '[b]\1[/b] #\2',
   '<a href="#\1">#\1</a>','[br]','<br>','<p>\1</p>','<b>\2</b>','<i>\1</i>','<u>\1</u>','<img src="\1">','<a href="\1">\1</a>',
    '<table class="bbtable">\1</table>',
    '<tr>\1</tr>',
    '<td>\1</td>',
    '<ul>\1</ul>',
    '<ol>\1</ol>',
    '<li>\1</li>',
   '<a href="\1">\2</a>'
   );
    //заменяем и возвращаем результат
    $result = preg_replace($from, $to,trim($text));
    return $result;*/
}
?>