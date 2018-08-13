<{if $user->reqRights('view_store_categories')}>
	<a href="<{$run.me}>/edit-category/catid_0/">Категории</a>&nbsp;&nbsp;
<{/if}>
<{if $user->reqRights('add_store_product')}>
	<{if is_object($category)}>
		<a href="<{$run.me}>/add-product/catid_<{$category->category_id}>/">Добавить товар в <{$category->category_name}></a>
	<{else}>
		<a href="<{$run.me}>/add-product/catid_<{$category->category_id}>/">Добавить товар</a>
	<{/if}>
<{/if}>
&nbsp;&nbsp;
<a href="<{$run.me}>/orders-archive/">Архив заказов</a>&nbsp;&nbsp;
<a href="<{$run.me}>/add-order/">Добавить заказ</a>