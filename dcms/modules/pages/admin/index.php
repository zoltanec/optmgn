<?php
//Кол-во активных страниц
$active_pages = Pages_StaticPage::getTree(0,0,true);
$T['active_total'] = Pages_StaticPage::$total;
//Кол-во всех страниц
$pages = Pages_StaticPage::getTree();
$T['total'] = Pages_StaticPage::$total;
//Количество отступов текущего элемента дерева
//У вложенных элементов должны быть отступы
$T['tree_paragraph'] = 0;
//Получение дерева
$T['tree_object'] = Pages_StaticPage::getTreeArray(0, true);
?>