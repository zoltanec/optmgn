<h4>Конфигурации модуля feedback</h4>

<div style="width:300px">	
<table class="cms_list">
	<thead>
	<tr>
		<th><b>Идентификатор</b></th>
		<th><b>Название</b></th>
		<th><b>Функции</b></th>
		
	</tr>
	</thead>

	<{foreach item=val from=$confs}>
		<tbody>
			<tr >
				<td align="center">
					<{$val['confid']}>
				</td>
				<td>
					<a href="<{$run.me}>/edit-conf/confid_<{$val['confid']}>"><{$val['confname']}></a>
				</td>
				<td>
					<a href="<{$run.me}>/delete-conf/confid_<{$val['confid']}>">Удалить</a>
				</td>	
			</tr>
		</tbody>
	<{/foreach}>
</table>
</div>