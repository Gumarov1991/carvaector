<div class="container min-h-500">
        <div class="row">
                <div clas="col-xl-12 col-lg-12">

<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<a href="./index.php?account" class=nav>{$content_261}</a>
	&nbsp;&#187;&nbsp;
	<span class=nav>{$content_263}</span>
</p>
<form method="post" action="./index.php?my">
	<input type=hidden name=save value=yes>
	<table border=0 cellspacing=0 cellpadding=0 width=815 style="margin:30px 80px 10px 80px;">
		<tr><td colspan=2 class=form-h1>{$user.email}</td></tr>
		<tr><td colspan=2 height=10> </td></tr>
		<tr>
			<td class=form-h2 align=right><b>{$content_443}</b></td>
			<td>
				<select name="gender" style="width:60px;margin-left:10px;">
					<option value="1"{if $user.gender != 2} selected{/if}>{$content_441}</option>
					<option value="2"{if $user.gender == 2} selected{/if}>{$content_442}</option>
				</select>
			</td>
		</tr>
		<tr><td class=form-h2 align=right><b>{$content_272}</b></td><td><input name=cus_name value="{$user.cus_name}" class=form-h3></td></tr>
		<tr><td class=form-h2 align=right><b>{$content_276}</b></td><td><input name=cus_country value="{$user.cus_country}" class=form-h3>
		<tr><td class=form-h2 valign=top align=right><b>{$content_278}</b></td><td><textarea name=cus_address class=form-h3 rows=2>{$user.cus_address}</textarea></td></tr>
		<tr><td class=form-h2 align=right><b>{$content_280}</b></td><td><input name=cus_phone value="{$user.cus_phone}" class=form-h3></td></tr>
		<tr><td class=form-h2 align=right><b>{$content_281}</b></td><td><input name=cus_mphone value="{$user.cus_mphone}" class=form-h3></td></tr>
		<tr><td class=form-h2 align=right><b>{$content_283}</b></td><td><input name=cus_skype value="{$user.cus_skype}" class=form-h3></td></tr>
		<tr><td class=form-h2 valign=top align=right><b>{$content_284}</b></td><td><textarea name=cus_info class=form-h3 rows=4>{$user.cus_info}</textarea></td></tr>
		{if $user.unsubscribed}
			<tr>
				<td class=form-h2 align=right>{$content_449}</td>
				<td class=form-h2 align=left>
					<input type="hidden" name="massmail" value="0">
					<input type="checkbox" name="massmail" value="1" {if $user.massmail == 1} checked{/if} style="margin-left:10px;">
				</td>
			</tr>
		{/if}
		<tr><td></td><td><input type=submit value="{$content_285}" style="margin:3px 10px 20px 10px;"></td></tr>
	</table>
</form>

</div>
</div>
</div>
