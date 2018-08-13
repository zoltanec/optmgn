<h2>Архив заказов</h2>
<table class="cms_calendar">
	<thead>
		<tr>
			<th><a href="<{$run.me}>/orders-archive/day_<{$cday->prev_month_end->format('%Y-%m-%d')}>">&larr;</a></th>
			<th colspan="5"><{$cday->month_full}></th>
			<th><a href="<{$run.me}>/orders-archive/day_<{$cday->next_month_start->format('%Y-%m-%d')}>">&rarr;</a></th>
		</tr><tr>
			<th>ПН</th>
			<th>ВТ</th>
			<th>СР</th>
			<th>ЧТ</th>
			<th>ПТ</th>
			<th>СБ</th>
			<th>ВС</th>
		</tr>
	</thead>

<{foreach item=week from=$calendar}>
	<tr class="week">
		<{foreach item=day from=$week}>
		<td<{if $cday->format('%Y%m%d') == $day.day->format('%Y%m%d')}> class="cms_calendar_current"<{/if}>><a href="<{$run.me}>/orders-archive/day_<{$day.day->format('%Y-%m-%d')}>"><{$day.day->format('%d')}></a></td>
		<{/foreach}>
	</tr>
<{/foreach}>
</table>

<h2>Статистика по заказам</h2>

<table class="cms_stat">
	<tr>
		<td>Дата: </td>
		<td><{$cday->format('%d / %m / %Y')}></td>
	</tr>
	<tr>
		<td>Общее количество заказов: </td><td><{$stat.count}></td>
	</tr>
	<tr>
		<td>Общая сумма:</td><td><{$stat.sum}>руб</td>
	</tr>
</table>

<h2>Список заказов</h2>

<{foreach  item=order from=$orders}>
	<{include file='admin/single-order'}>
<{/foreach}>

<script type="text/javascript">
		$(document).ready(function(){
		    function runmsg(){
				$.post(siteVars.www+'/admin/run/store/check-orders',function(answer){
					if(answer)
						alert("У вас "+answer+" новых заказа");
				});
		    }
		    var msg_timer = setInterval(runmsg, 20000);
		});	
</script>