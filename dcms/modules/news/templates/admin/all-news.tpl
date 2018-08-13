<h1>Архив новостей</h1>

<{capture name="news_page_url"}>
<{$run.me}>/all-news/!PAGE!/
<{/capture}>

<div class="cms_admin_pager">
<{pager pager='fast' mode='reverse' total=$newslist->total_pages url=$smarty.capture.news_page_url current=$newslist->page}>
</div>

<table class="cms_list" id="all_news_table" data-list-funcs="delete active edit">
 <thead>
  <tr>
  		<th><input type="checkbox" name="select_unselect_all"></th>
        <th>No</th>
        <th>NID</th>
        <th>S</th>
        <th>Время</th>
        <th>Заголовок</th>
        <th colspan="2">#FUNCTIONS#</th>
    </tr>
    </thead>

	<tbody class="cms_table_menu">
		<tr>
			<td colspan="7">МЕНЮ</td>
		</tr>
	</tbody>

 	<tr>
 		<td colspan="3">Поиск по заголовку:</td>
 		<td colspan="5">
 		<form action="<{$run.me}>/find-news/" method="post">
 		<input class="search" size="65" type="text" name="search" value="<{$query}>">
 		<input type="submit" class="submit_find" value="#SEARCH#">
 		</form>
 		</td>
 	</tr>

    <{foreach item=news from=$newslist}>
	<tbody data-type="element" data-id="<{$news->nid}>" data-active="<{$news->active}>" data-object-id="<{$news->object_id()}>">
        <tr class="single_news" id="news<{$news->nid}>">
            <td class="check"><input type="checkbox" data-id="<{$news->nid}>" name="check"></td>
            <td class="num"><b><{$news->num}>.</b></td>
            <td><b><{$news->nid}></b></td>
            <td class="active"></td>
            <td class="add_time"><{$news->add_time|convert_time}></td>
            <td class="news_title" data-name="title"><{$news->title|left:"70"}></td>
            <td class="edit" data-url="<{$run.me}>/edit-news/nid_<{$news->nid}>/"></td>
            <td class="delete"></td>
        </tr>
	</tbody>
    <{/foreach}>
</table>

<div class="cms_admin_pager">
<{pager pager='fast' mode='reverse' total=$newslist->total_pages url=$smarty.capture.news_page_url current=$newslist->page}>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.single_news').each(function() {
		var news = $(this);
		news.find('.delete_link').click(function() {
			if(confirm('Вы действительно хотите удалить новость?')) {
				$.get($(this).attr('href'), function(answer) {
					if(answer.status == 'OK') {
						$('#' + news.attr('id')).remove();
					}
				},'json');
			}
			return false;
		});
	});
});
</script>