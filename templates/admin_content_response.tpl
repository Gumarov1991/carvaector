	<table cellpadding=0 cellspacing=0 align=left>
		<tr>
			<td>
				<table border=0 cellpadding=0 cellspacing=0 style="margin:0px 10px 0px 10px;">
						<tr>
							<td><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&add=add" title="Добавить отзыв клиента">(+)</a></td>
							<td>&nbsp;&nbsp;
								<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$edit}&response_up=yes" title="Переместить вверх">вверх</a>
								&nbsp;
								<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$edit}&response_down=yes" title="Переместить вниз">вниз</a>
							</td>
						</tr>
				</table>
				<table border=0 cellpadding=0 cellspacing=1 style="margin:0px 10px 0px 10px;" bgColor=#bbb>
						<tr>
							<td style="font-size:11px;text-align:center;background-color: #ffffff;padding: 0px 4px 0px 4px;"><b>page</b></td>
							<td style="font-size:11px;text-align:center;background-color: #ffffff;padding: 0px 4px 0px 4px;"><b>description</b></td>
						</tr>
					{foreach item = row from = $response_list key=i}
						<tr>
						<td style="font-size:11px;text-align:right;background-color: #ffffff;padding: 0px 4px 0px 4px;"title="folder={$row.id}">{if $row.num}{$row.num} {else} {/if}</td>
						<td style="background-color: #ffffff;padding: 0px 4px 0px 4px;">
							<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$row.id}" style="color:#{if $row.confirm}000000{else}666666{/if};font-size:11px;{if $edit==$row.id}text-decoration:underline;font-weight: bold;{else}font-weight: normal;{/if}">
							{$row.name}</a>
						</td>
						</tr>
					{/foreach}
				</table>
			</td>
			<td valign=top>
			{if $edit}
				<table cellpadding=0 cellspacing=0 style="margin:0px 10px 30px 10px;">
					<tr>
						<td>
							<form action="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$edit}" method=post>
							<input type=hidden name=save value=yes>
								<table border=0 cellpadding=0 cellspacing=0 style="margin:0px 10px 0px 10px;">
									<tr>
										<td colspan=6>
											<p style="font-size:14px;">От клиента: {if $usr.id}<a href="./admin.php?users&id={$usr.id}" style="font-size:14px;color:#000000;font-weight:normal;"><u>{$usr.name} (SiteID-{$usr.id})</u></a>{/if}</p>
										</td>
									</tr>
									<tr>
										<td width=650>
											<input name=name value="{$r.name}" style="border:1px solid #008000;width:300px;">
										</td>
										<td align=right>Язык&nbsp;</td>
										<td>
											<select name=language_id size=1>
											{foreach item = row from = $languages}
											<option value="{$row.id}"{if $row.id==$r.language_id} selected{/if}>{$row.name}</option>
											{/foreach}
											</select>
										</td>
										<td align=right>
											<input type="hidden" name="en" value="0">
											<input type="checkbox" name="en" value="1"{if $r.confirm} checked{/if}>											
										</td>
										<td>&nbsp;одобрено</td>
										<td align=right><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&response_del={$edit}" onClick="return confirm('Вы уверены, что хотите удалить этот отзыв?');"><img src="./pics/del.gif" border=0 width=9 height=10 alt="Удалить отзыв" title="Удалить отзыв"></a></td>
									</tr>
									<tr>
										<td colspan=6>
											<textarea id=msg_id name=msg style="border:1px solid #008000;width:935px;height:300px;">{$r.message}</textarea>
										</td>
									</tr>
									<tr>
										<td colspan=6 style="padding-top:5px;">
											<input type=image src="./pics/admin-save.gif" width=107 height=20>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
					<tr>
						<td valign=top>{include file="admin_content_files.tpl"}</td>
					</tr>
				</table>
			{/if}
			</td>
		</tr>
	</table>
