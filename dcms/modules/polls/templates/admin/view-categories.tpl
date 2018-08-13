<h2>Управление категориями в опросе</h2>

<a href="<{$run.me}>/add-category-for-poll/<{$poll->poll_id}>/">#ADD#</a>
<table class="list">
<{foreach item=cat from=$poll->categories}>
	<form method="post" action="<{$run.me}>/update-category/<{$cat->catid}>/">
	<tbody>
		<tr>
			<td colspan="2"><input type="text" name="name" size="60" value="<{$cat->name}>"></td>
		</tr>
		<tr>
			<td colspan="2"><textarea rows="4" cols="70" class="cms_rich" name="descr"><{$cat->descr}></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" class="submit_update" value="#SAVE#"></td>
			<td><input type="submit" class="submit_delete" value="#DELETE#"></td>
		</tr>
	</tbody>
	</form>
<{/foreach}>
</table>