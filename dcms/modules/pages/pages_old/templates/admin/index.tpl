<h1>Управление статичным контентом</h1>
<{capture name="pages_page_url"}>
<{$run.me}>/index/!PAGE!/
<{/capture}>
<div class="cms_admin_pager">
<{pager mode='normal' total=$pages_list->total_pages url=$smarty.capture.pages_page_url current=$pages_list->page}>
</div>
<table class="cms_list" data-list-funcs="delete active edit">
    <thead>
    	<tr>
    	    <th>Номер</th>
    		<th>ID</th>
        	<th>Псевдоним</th>
        	<th>Язык</th>
        	<th>Создан</th>
        	<th>Заголовок</th>
        	<th>S</th>
        	<th colspan="2">#FUNCTIONS#</th>
   		</tr>
   	</thead>
   <{foreach item=page from=$pages_list}>
  <tbody data-type="element" data-id="<{$page->content_id}>" data-active="<{$page->active}>" data-object-id="<{$page->object_id()}>">
     <tr id="page<{$page->content_id}>">
       <td class="num"><{$page->num}></td>
       <td class="center"><{$page->content_id}></td>
       <td data-name="title"><{if $page->content_name != ''}><{$page->content_name}><{else}><b>не указан</b><{/if}></td>
       <td class="center"><{$page->lang}></td>
       <td class="center"><{$page->add_time|convert_time}></td>
       <td><{$page->title}></td>
       <td class="active"></td>
       <td class="edit" data-url="<{$run.me}>/edit-page/contentid_<{$page->content_id}>/"></td>
	   <td class="delete"></td>
     </tr>
</tbody>
    <{/foreach}>
</table>
<div class="cms_admin_pager">
<{pager mode='normal' total=$pages_list->total_pages url=$smarty.capture.pages_page_url current=$pages_list->page}>
</div>