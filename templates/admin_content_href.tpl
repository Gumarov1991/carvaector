<table cellpadding=0 cellspacing=0 style="margin:0px 10px 30px 10px;">
        <form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method=post>
			<input type=hidden name=save value=yes>
			{foreach item = row from = $hrefs key=i}
				<tr bgColor=#{if fmod($i,2)==0}ffffff{else}e0e0e0{/if}>
					<td style="padding:1px 10px 1px 10px;">
						<input name=name{$row.id} value="{$row.name}" style="border:1px solid #000000;width:300px;">
					</td>
					<td style="padding:1px 10px 1px 10px;">
						<input name=href{$row.id} value="{$row.href}" style="border:1px solid #000000;width:300px;">
					</td>
					<td style="padding:1px 10px 1px 10px;"><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&del={$row.id}" onClick="return confirm('Вы хотите удалить ссылку &#171;{$row.name}&#187;?');"><img src="./pics/del.gif" border=0 width=9 height=10></a></td>
				</tr>
			{/foreach}
			<tr>
				<td style="padding-top:5px;">
					<input type=image src="./pics/admin-save.gif" width=107 height=20>
					&nbsp;
					<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&add">
						<img src="./pics/admin-add.gif" width=107 height=20 border=0>
					</a>
				</td>
			</tr>
        </form>
</table>
