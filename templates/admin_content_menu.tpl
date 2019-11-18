<table border=0 cellspacing=0 cellpadding=0 {if $beg}style="margin:0px 10px 10px 10px;"{/if}>
{foreach item = row from = $res}
	<tr>
		<td width=10>
			{if $row.res}
				<img id=p{$row.id} 
					src="./pics/admin_content{if $row.last}{if $row.dis}7{else}6{/if}{else}{if $row.dis}5{else}4{/if}{/if}.gif" width=10 height=20 
					onClick="
						var o=document.getElementById('v{$row.id}').style;
						var p=document.getElementById('p{$row.id}');
						if (o.display=='none') p.src='./pics/admin_content{if $row.last}7{else}5{/if}.gif'; 
							else p.src='./pics/admin_content{if $row.last}6{else}4{/if}.gif';
						if (o.display=='none') o.display='inline'; 
							else o.display='none';
					">
			{else}
				<img src="./pics/admin_content{if $row.last}2{else}1{/if}.gif" width=10 height=20>
			{/if}
		</td>
		<td nowrap style="padding-left:2px;">
			<a href="./admin.php?content{if $admin_contents}s{else}&lang_id={$lang_id}{/if}&id={$row.id}" class=menu {if $row.id==$id}style="text-decoration: underline;"{/if}>
				{$row.name}
			</a>
		</td>
	</tr>
	{if $row.res}
		<tr>
			<td width=10 {if !$row.last}background="./pics/admin_content3.gif"{/if}></td>
			<td>
				<span id=v{$row.id}{if !$row.dis} style="display:{if $row.id != 1}none{else}inline{/if};"{/if}>
					{include file="admin_content_menu.tpl" res=$row.res beg=""}
				</span>
			</td>
		</tr>
	{/if}
{/foreach}
</table>
