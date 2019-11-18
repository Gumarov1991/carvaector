{literal}
<script type="text/javascript">
function submitForm(id){
document.getElementById(id).target="_blank";
document.getElementById(id).submit();
}
</script>
{/literal}

<div class="container min-h-500">
<div class="row">
<div class="col-12">
<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<span class=nav>{$content_261}</span>
	&nbsp;&#187;&nbsp;
	<span class=nav>{$fio}</span>
</p>

<table border=0 cellspacing=0 cellpadding=0 width=815 style="margin:30px 80px 10px 80px;">
	<tr>
		<td valign=top width=350>
			<p class=us-m><a href="./index.php?my" class=us-m>{$content_263}</a></p>
			<p class=us-m><a href="https://carvector.com/car-search/account?lang={$lang_code}" class=us-m>{$content_494}</a></p>
			<p class=us-m><a href="./index.php?zak" class=us-m>{$content_264}</a></p>
			<p class=us-m><a href="./index.php?bal" class=us-m>{$content_265}</a></p>
			<p class=us-m><a href="./index.php?resp" class=us-m>{$content_266}</a></p>
			<p class=us-m><a href="./index.php?newpass" class=us-m>{$content_267}</a></p>
			<p class=us-m><a href="./index.php?term" class=us-m>{$content_433}</a></p>
			<br><br>
			<p class=us-m><a href="./index.php?quit" class=us-m>{$content_262}</a></p>
		</td>
		<td valign=top>
			<p class=us-m>
				<a href="./index.php?auchouses" class=us-m>{$content_268}</a></br><br>
				<a href="./index.php?gradsys" class=us-m>{$content_269}</a><br><br>
			{if $direct}
				<a href="./index.php?myear" class=us-m>{$content_271}</a>
			{/if}
			<p>
			{if $direct}
				<p class=us-m>
					<a href="./index.php?direct" class=us-m>{$content_409}-1 (Japan)</a><br>
					(<a href="./index.php?instr_1">{$content_438}</a>)
				</p>
				<p class=us-m>
					<form style="margin:0px" action="http://carvector.ajes.com" method="post" id="form1" onSubmit="document.form1.target='_blank';">
						<input type="hidden" name=username value="{$cus_auclogin}">
						<input type="hidden" name=password value="{$cus_aucpass}">
						<input type="hidden" name=is_login value="1">
						<input type="hidden" name=ref value="aj">
						<input type="hidden" name="redirect" value="">
						<input type="hidden" name="mode" value=>
						<input type="hidden" name="f" value=>
						<input type="hidden" name="t" value=>
						<input type="hidden" name="op" value="login">
					</form>
					<a href="#" onClick="submitForm('form1');" title="first save the login and password and then go to the link">
						<span style="font-weight: bold;font-size: 14px;color: #000000;">
							{$content_409}-2 (Japan and USA)
						</span>
					</a>
					<br>
					<form method="post" action="./index.php?account">
						<div style="text-align: right; padding:6px; border:1px solid #bbbbbb; width:330px;">
							<table border=0>
								<tr>
									<td align=right nowrap>
										Login: <input name=auclogin value="{$cus_auclogin}" class=adm-us style="width:180px;"><br>
										Password: <input name=aucpass value="{$cus_aucpass}" class=adm-us style="width:180px;"><br>
									</td>
									<td align=center valign=middle>
										<input type="submit" value="Save" name="save" style="width:50px;background: #99ff66;">&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</div>
						(<a href="./index.php?instr_2">{$content_438}</a>)
					</form>
				</p>
			{/if}
			<p class=us-m style="margin-bottom: 10px;"><span class=nav>{$content_270}:</span></p>
			{foreach item = row from = $hrefs}
				<p class=us-m style="margin-bottom: 5px;"><a href="{$row.href}" class=us-m style="color: #909090;" target=_blank>{$row.name}</a></p>
			{/foreach}
		</td>
	</tr>
</table>
</div>
</div>
</div>
