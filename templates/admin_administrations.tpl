{if $logg}
<table cellspacing=1 cellpadding=0 width=100% style="margin:10px 0px 50px 0px;" bgColor=#000000>
	<tr>
		<td class=form-ha><b>Дата</b></td>
		<td class=form-ha><b>ID</b></td>
		<td class=form-ha><b>Логин</b></td>
		<td class=form-ha><b>IP</b></td>
		<td class=form-ha><b>IP-info</b></td>
		<td class=form-ha><b>Visited Pages</b></td>
	</tr>
	{foreach item = row from = $logs}
			<tr>
				<td class=form-ta>{$row.date}</td>
				<td class=form-ta>{$row.login_id}</td>
				<td class=form-ta>{$row.login}</td>
				<td class=form-ta>{$row.ip}</td>
				<td class=form-ta nowrap>{$row.ip_info}</td>
				<td class=form-ta width=100%>{$row.page}</td>
			</tr>
	{/foreach}
</table>
{elseif $id}
	<form action="./admin.php?admins&id={$id}" method=post>
		<input type=hidden name=save value=yes>
		<table cellspacing=1 cellpadding=0 width=400 style="margin:10px 20px 0px 20px;" bgColor=#80ff70>
			<tr>
				<td class=form-t1>ID for OCS:</td>
				<td class=form-t1><input name=idocs value="{$r.idocs}" style="width:300px;border:1px solid #80ff70;"></td>
			</tr>
			<tr>
				<td class=form-t1>LOG:</td>
				<td class=form-t1><input name=log value="{$r.login}" style="width:300px;border:1px solid #80ff70;"></td>
			</tr>
			<tr>
				<td class=form-t1>Пароль:</td>
				<td class=form-t1><input name=pass value="{$r.pass}" style="width:300px;border:1px solid #80ff70;"></td>
			</tr>
			<tr>
				<td class=form-t1>ФИО:</td>
				<td class=form-t1><input name=name value="{$r.name}" style="width:300px;border:1px solid #80ff70;"></td>
			</tr>
			<tr>
				<td class=form-t1>E-mail:</td>
				<td class=form-t1><input name=email value="{$r.email}" style="width:300px;border:1px solid #80ff70;"></td>
			</tr>
			<tr>
				<td class=form-t1>Примечания:</td>
				<td class=form-t1><textarea name=note style="width:300px;height:100px;border:1px solid #80ff70;">{$r.note}</textarea></td>
			</tr>
			<tr>
				<td class=form-t1>Тип:</td>
				<td class=form-t1>
					<select size=1 name=type style="width:300px;border:1px solid #80ff70;">
						<option value="1"{if $r.type==1} selected{/if}>admin</option>
						<option value="2"{if $r.type==2} selected{/if}>mpo</option>
						<option value="3"{if $r.type==3} selected{/if}>mpf</option>
						<option value="4"{if $r.type==4} selected{/if}>spr</option>
						<option value="5"{if $r.type==5} selected{/if}>logist</option>
					</select>
				</td>
			</tr>
		</table>
		<table cellspacing=0 cellpadding=0 width=400 style="margin:10px 20px 50px 20px;">
			<tr>
				<td>
					<input type=image src="./pics/admin-save.gif" width=107 height=20>
					<a href="./admin.php?admins"><img src="./pics/admin-cancel.gif" width=107 height=20 border=0></a>
				</td>
			</tr>
		</table>
	</form>
{else}
	<form action="./admin.php?admins" method=post>
		<input type=hidden name=save value=yes>
		<table cellspacing=0 cellpadding=0 width=100% style="margin:10px 0px 0px 0px;">
			<tr>
				<td><input type=image src="./pics/admin-grant.gif" width=107 height=20></td>
				<td align=center><a href="./admin.php?admins&logg=yes" style="padding: 1px 5px; border: 1px solid rgb(0, 0, 51);">Лог посещений</a></td>
				<td align=right><a href="./admin.php?admins&id=add"><img src="./pics/admin-add.gif" width=107 height=20 border=0></a></td>
			</tr>
		</table>
		<table cellspacing=1 cellpadding=0 width=100% style="margin:5px 0px 50px 0px;" bgColor=#000000>
			<tr>
				<td class=form-ha nowrap></td>
				<td class=form-ha><b>ID<br>for</br>OCS</b></td>
				<td class=form-ha><b>ФИО</b></td>
				<td class=form-ha><b>LOG</b></td>
				<td class=form-ha><b>PASS</b></td>
				<td class=form-ha><b>OFFLINE</b></td>
				<td class=form-ha><b>IP-INFO</b></td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>данных<br>кл-тов</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Запись<br>данных<br>в OCS</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>заказов<br>кл-тов</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>балансов<br>кл-тов</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Temp<br>edit<br>access</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>табл.<br>дост-к</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>стр.<br>отз-ов</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Ред.<br>стр.<br>воп-отв</td>
				<td class=form-ha nowrap align=center style="font-size:10px;">Участие<br>в чатах</td>
				<td class=form-ha width=100%><b>Примечания</b></td>
			</tr>
			{foreach item = row from = $admins}
				<tr>
					<td class=form-ta nowrap>
						{if $row.id!=1}<a href="./admin.php?admins&del={$row.id}" onClick="return confirm('Вы уверены, что хотите удалить менеджера с ID = {$row.id}');"><img src="./pics/del.gif" border=0 width=9 height=10></a>{/if}
						<a href="./admin.php?admins&id={$row.id}"><img src="./pics/edit.gif" border=0 width=9 height=10 alt="Редактировать данные менеджера" title="Редактировать данные менеджера"></a>
					</td>
					<td class=form-ta align=right>{$row.idocs}</td>
					<td class=form-ta><a href="./admin.php?admins&id={$row.id}" style="font-weight:normal;color:#000000;font-size:14px;"><u>{$row.name}</u></a></td>
					<td class=form-ta>{$row.login}</td>
					<td class=form-ta>{$row.pass}</td>
					<td class=form-ta title="ip={$row.ip}">{$row.ddays} days<br>{$row.dtime}</td>
					<td class=form-ta nowrap>{$row.country_by_ip|nl2br}</td>
					{foreach item = rows from = $row.grants}
						<td class=form-ta align=center><input type=checkbox name=gr{$rows.id}_{$row.id} value=yes{if $rows.ch} checked{/if}{if $row.id==1} disabled{/if}></td>
					{/foreach}
					<td class=form-ta>{$row.note}</td>
				</tr>
			{/foreach}
		</table>
	</form>
{/if}
