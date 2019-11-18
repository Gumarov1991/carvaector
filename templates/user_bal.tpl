<div class="container min-h-500">
        <div class="row">
                <div clas="col-xl-12 col-lg-12">

<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<a href="./index.php?account" class=nav>{$content_261}</a>
	&nbsp;&#187;&nbsp;
	<span class=nav>{$content_265}</span>
</p>
<table cellspacing=1 cellpadding=0 width=1160 style="margin:20px 0px 20px 0px;" bgColor=#000000>
	<tr>
		<td class=form-ha width=100 align=center><b>{$content_382}</b></td>
		<td class=form-ha align=center><b>{$content_302}</b></td>
		<td class=form-ha width=100 align=center><b>{$content_301}</b></td>
		<td class=form-ha width=100 align=center><b>{$content_402}</b></td>
	</tr>
	{foreach item = row from = $bals}
		<tr>
			<td class=form-ta align=center width=100>{$row.dt}</td>
			<td class=form-ta>{$row.operation}</td>
			<td class=form-ta width=100 align=right{if $row.summ < 0} style="color:red;"{/if}>{$row.summ}</td>
			<td class=form-ta width=100 align=right{if $row.summ2 < 0} style="color:red;"{/if}>{$row.summ2}</td>
		</tr>
	{/foreach}
	<tr>
		<td class=form-ta></td>
		<td class=form-ta align=right colspan=2><b>{$content_303}</b></td>
		<td class=form-ta align=right colspan=2{if $summ < 0} style="color:red;"{/if}><b>{$summ}</b></td>
	</tr>
</table>

</div>
</div>
</div>
