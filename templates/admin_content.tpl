<table border=0 cellpadding=0 cellspacing=0 style="margin:10px 0px 0px 0px;">
	<tr>
		<td valign=top nowrap>
			<select size=1 style="margin:1px 10px 1px 10px;" onChange="window.location='./admin.php?content&lang_id='+this.value+'&id={$id}';">
				{foreach item = row from = $languages}
					<option value="{$row.id}"{if $row.id==$lang_id} selected{/if}>{$row.name}</option>
				{/foreach}
			</select><label title="Использовать визуальный редактор для многострочных полей">Ckeditor
			<input type="checkbox"{if $cked==1} checked{/if} onclick='this.blur();' onChange="window.location='./admin.php?content&cked='+this.checked+'&id={$id}';"></label>
			{include file="admin_content_menu.tpl" res=$contents beg="yes"}
			{if $login_admin=="admin"}
				<p style="margin:0px 22px 5px 22px;"><a href="./admin.php?content&lang_id={$lang_id}&id=files" class=menu {if $id=="files"}style="text-decoration: underline;"{/if}>Файлы</a></p>
				<p style="margin:0px 22px 5px 22px;"><a href="./admin.php?content&lang_id={$lang_id}&id=ipload" class=menu {if $id=="ipload"}style="text-decoration: underline;"{/if}>IP таблица</a></p>
			{/if}
		</td>
		<td width=1 bgColor=#000000 nowrap></td>
		<td valign=top width=100%>
			{if $id=="ipload"}
				{include file="admin_content_ipload.tpl"}
			{elseif $id=="files"}
				{include file="admin_content_files.tpl"}
			{elseif $id=="href"}
				{include file="admin_content_href.tpl"}
			{elseif $id=="error"}
				{include file="admin_content_error.tpl"}
			{elseif $id=="hot"}
				{include file="admin_content_hot.tpl"}
			{elseif $id=="response"}
				{include file="admin_content_response.tpl"}
			{elseif $id=="dostavka"}
				{include file="admin_content_dostavka.tpl"}
			{elseif $id=="faq"}
				{include file="admin_content_faq.tpl"}
			{elseif $id}
				{include file="admin_content_content.tpl"}
			{/if}
		</td>
	</tr>
</table>
