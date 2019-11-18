<div class="container min-h-500">
	<div class="row">
		<div clas="col-xl-12 col-lg-12">

{if $car.id}

	<p style="font-size:14px;margin:10px 0px 0px 10px;">
		<a href="./index.php?catalog" class=nav>{$content_4}</a>
		&nbsp;&#187;&nbsp;
		<a href="./index.php?catalog&maker={$car.marka}" class=nav>{$car.marka}</a>
		&nbsp;&#187;&nbsp;
		<a href="./index.php?catalog&maker={$car.marka}&model={$car.model}" class=nav>{$car.model}</a>
		&nbsp;&#187;&nbsp;
		<span class=nav>{$car.marka} {$car.model} {$car.modif}</span>
	</p>
	<table cellspacing=2 cellpadding=2 align=center style="font-family:Tahoma Arial;font-size:14px;width:701px;margin:30px 137px 30px 137px;">
		<tr>
			<td colspan=2 align=center>
				<img src = "./imgcatalog.php?i={$car.pic}" align=center>
			</td>
		</tr>
		{foreach item = row from = $car_params key=i}
			{if $row.name != "info_ref"}
				<tr>
					<td{if fmod($i,2)!=0} bgColor=#f2f2f2{/if}>{$row.name}</td>
					<td{if fmod($i,2)!=0} bgColor=#f2f2f2{/if} style="text-transform:uppercase;">{$row.value}</td>
				</tr>
			{/if}
		{/foreach}
	</table>

{elseif $model}

	<p style="font-size:14px;margin:10px 0px 0px 10px;">
		<a href="./index.php?catalog" class=nav><u>{$content_4}</u></a>
		&nbsp;&#187;&nbsp;
		<a href="./index.php?catalog&maker={$maker}" class=nav><u>{$maker}</u></a>
		&nbsp;&#187;&nbsp;
		<span class=nav>{$model}</span>
	</p>
	{foreach item = row from = $modifs}
		<table border=0 width=955 cellspacing=0 cellpadding=0 style="margin:30px 10px 0px 10px;border-bottom:1px solid #cccccc;">
			<tr>
				<td colspan=1 valign=bottom width=400>
					<p style="font-size:16px;font-weight: bold;color:#444;margin: 0px 0px 20px 5px;">{$content_142} {$row.date}</p>
				</td>
				<td colspan=4 align=right valign=bottom>
					<img src="./imgcatalog.php?i={$row.pic}" width=200 style="border:1px solid #cccccc;margin-bottom:10px;">
				</td>
			</tr>
			<tr bgColor=#F2F2F2>
				<td class=cat-h>{$content_52}</td>
				<td class=cat-h width=150>{$content_53}</td>
				<td class=cat-h width=150>{$content_64}</td>
				<td class=cat-h width=150>{$content_85}</td>
				<td class=cat-h width=70>{$content_86}</td>
			</tr>
			{foreach item = rows from = $row.res}
				<tr>
					{foreach item = rowss from = $rows.res name=m}
						<td style="border-bottom: 1px solid #D0D0D0;padding: 2px 5px 2px 5px;">
							{if $smarty.foreach.m.first}<a href="./index.php?catalog&id={$rows.0}">{/if}
							{$rowss.0}
							{if $smarty.foreach.m.first}</a>{/if}
						</td>
					{/foreach}
				</tr>
			{/foreach}
		</table><br>
	{/foreach}
	<br><br>

{elseif $maker}

	<p style="font-size:14px;margin:10px 0px 0px 10px;">
		<a href="./index.php?catalog" class=nav><u>{$content_4}</u></a>
		&nbsp;&#187;&nbsp;
		<span class=nav>{$maker}</span>
	</p>
	<p style="margin:20px;">
		<table border=0>
		{assign var="count" value=1}
		<tr>
			{foreach item = row from = $models}
				<td style="width:180px;height:30px;"><a href="./index.php?catalog&maker={$maker}&model={$row.model}" style="color:#666666;">{$row.model}</a></td>
				{if fmod($count,5)==0}</tr><tr>{/if}
				{assign var="count" value=$count+1}
			{/foreach}
		</tr>
		</table>
	</p>

{else}

	<p style="font-size:14px;margin:10px 0px 20px 10px;">
		<span class=nav>{$content_4}</span>
	</p>

	{foreach item = row from = $countries}
		<p style="margin:20px;font-size:18px;font-weight:bold;">
			{if $row.country == "Japan"}<img src="./pics/flags_22-14/jp.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_418}
			{elseif $row.country == "USA"}<img src="./pics/flags_22-14/us.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_419}
			{elseif $row.country == "Germany"}<img src="./pics/flags_22-14/de.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_420}
			{elseif $row.country == "France"}<img src="./pics/flags_22-14/fr.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_421}
			{elseif $row.country == "Italy"}<img src="./pics/flags_22-14/it.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_422}
			{elseif $row.country == "Great Britain"}<img src="./pics/flags_22-14/gb.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_423}
			{elseif $row.country == "Korea"}<img src="./pics/flags_22-14/kr.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_424}
			{elseif $row.country == "Sweden"}<img src="./pics/flags_22-14/se.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_425}
			{elseif $row.country == "Other"}<img src="./pics/flags_22-14/00.png" style="border: 1px solid #bbb;">&nbsp;&nbsp;{$content_426}
			{else}{$row.country}{/if}<br>
			<table border=0 style="margin: 10px 0px 0px 20px;">
				{assign var="cnt" value=1}
				<tr>
					{foreach item = row2 from = $markas}
						{if $row.country == $row2.country}
							<td style="width:150px;height:30px;"><a href="./index.php?catalog&maker={$row2.marka}" style="font-size:14px;padding:10px;color:#666666;">{$row2.marka}</a></td>
							{if fmod($cnt,4)==0}</tr><tr>{/if}
							{assign var="cnt" value=$cnt+1}
						{/if}
					{/foreach}
				</tr>
			</table>
			<hr align="left" size="0" style="margin-left:15px; width:630px;">
		</p>
	{/foreach}

{/if}

</div>
</div>
</div>
