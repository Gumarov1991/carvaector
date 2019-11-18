<div class="container min-h-500">
        <div class="row">
                <div clas="col-xl-12 col-lg-12">

<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<a href="./index.php?account" class=nav>{$content_261}</a>
	{if $files}
		&nbsp;&#187;&nbsp;
		<a href="./index.php?zak" class=nav>{$content_264}</a>
		&nbsp;&#187;&nbsp;
		<span class=nav>{$zak_name}</span>
	{else}
		&nbsp;&#187;&nbsp;
		<span class=nav>{$content_264}</span>
	{/if}
</p>
{if $files}
	<table border=0 FRAME=BOX RULES=ALL cellpadding=0 cellspacing=0 style="margin:20px 0px 20px 10px;" bgColor=#ffffff>
		{foreach item = row from = $pics key=i}
			{if fmod($i,3)==0}<tr>{/if}
				<td bgColor=#ffffff valign=top>
					{if $row.href}
						<a href="{$row.href}" target=_blank>
							<img src="{if $row.ext!="pic"}{$row.ext}{else}./get_image.php?pic={$row.url}&w=100&h={$row.xy.1*100/$row.xy.0}{/if}"{if $row.ext=="pic"} width="100" height="{$row.xy.1*100/$row.xy.0}"{/if} border=0 style="margin:3px 10px 0px 10px;">
						</a>
						<p style="margin:0px 10px 3px 10px;font-size:10px;">
							<a href="{$row.href}" target=_blank style="font-size:10px;color:#000000;">{$row.name}</a>
						</p>
					{/if}
				</td>
			{if fmod($i,3)==2}</tr>{/if}
		{/foreach}
	</table>
{else}
	{if !$zaks}<p style="margin:30px 20px 20px 20px;">{$content_291}</p>
	{else}
		<table cellspacing=0 cellpadding=0 width=975 style="margin-top:20px;">
			<tr height=25 style="font-weight:bold;text-align:center;" bgColor=#99ff66>
				<td class=head-s style="background:url(./pics/head2.gif);">{$content_286}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_288}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_287}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_289}</td>
				<td class=dot-h></td>
				<td class=head-s style="background:url(./pics/head2.gif) right top;">{$content_290}</td>
			</tr>
			<tr height=2><td colspan=19></td></tr>
			{foreach item = row from = $zaks name=res}
				<tr>
					<td class=search style="padding-left:10px;" align=center>{$row.trno}</td>
					<td class=dot></td>
					<td class=search align=center>{$row.dt}</td>
					<td class=dot></td>
					<td class=search>{$row.name} -> ({$row.alocation})</td>
					<td class=dot></td>
					<td class=search>{$row.logist}</td>
					<td class=dot></td>
					<td class=search align=center style="padding-right:10px;"><a href="./index.php?zak&files={$row.id}"><img src="./pics/admin-order.gif" width=25 height=21 border=0 alt="Файлы заказа" title="Файлы заказа"></a></td>
				</tr>
				{if !$smarty.foreach.res.last}<tr height=1 bgColor=#99ff66><td colspan=19></td></tr>{/if}
			{/foreach}
			<tr height=2><td colspan=19></td></tr>
			<tr height=25 style="font-weight:bold;text-align:center;" bgColor=#99ff66>
				<td class=head-s style="background:url(./pics/head2.gif);">{$content_286}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_288}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_287}</td>
				<td class=dot-h></td>
				<td class=head-s>{$content_289}</td>
				<td class=dot-h></td>
				<td class=head-s style="background:url(./pics/head2.gif) right top;">{$content_290}</td>
			</tr>
			<tr height=30><td colspan=19></td></tr>
		</table>
	{/if}
{/if}

</div>
</div>
</div>
