{if $bal}
	{if $bal2}
		<p align=left style="margin:10px 0px 0px 20px;">
			<a href="./admin.php?users&bal={$bal}" style="padding: 1px 5px; border: 1px solid rgb(0, 0, 51);">Balance by Date</a>
			&nbsp;&nbsp;&nbsp;
			<span style="font-size: 12px;font-weight: bold">Client SiteID:</span>&nbsp
			<span style="font-size: 14px;font-weight: normal">{$cl_id}</span>
			&nbsp;&nbsp;&nbsp;
			<span style="font-size: 12px;font-weight: bold">Client Name:</span>&nbsp
			<a href="./admin.php?users&sort=7&sort_str={$cl_id}" style="font-size: 14px;font-weight: normal; color: #000"><u>{$cl_name}</u></a>
		</p>
		<table  id="bal_table" cellspacing=1 cellpadding=0 width=100% style="margin:10px 0px 10px 0px;" bgColor=#000000>
			<tbody>
				<tr>
					{if $login_admin=="admin"}<td class=form-had width=30 colspan=2 nowrap></td>{/if}
					<td class=form-had width=150 align=center nowrap><b>Date Time</b></td>
					<td class=form-had align=center><b>Transaction</b></td>
					<td class=form-had width=100 align=center nowrap><b>Amount</b></td>
					<td class=form-had width=100 align=center nowrap><b>Balance</b></td>
				</tr>
			{foreach item = row key=k from = $bals}
				<tr id="{$row.total}" sort_id="{$row.sort_id}">
					{if $login_admin=="admin"}
						<td width=15 nowrap bgcolor="#ffffff">
							<a class="dnLine arrL" href="#"><img src="./pics/arr-down.gif" border=0 width=30 height=20></a>
						</td>
						<td width=15 nowrap bgcolor="#ffffff">
							<a class="upLine arrl" href="#"><img src="./pics/arr-up.gif" border=0 width=30 height=20></a>
						</td>
					{/if}
					<td class=form-ta name="date" width=150 nowrap title="sort_id={$row.sort_id}">{$row.ts}</td>
					<td class=form-ta name="oper" style="white-space: pre-wrap;empty-cells:show">{$row.operation}</td>
					<td class=form-ta name="summ" width=100 nowrap align=right {if $row.summ < 0}style="color: red"{/if}>{$row.summ}</td>
					<td class=form-ta abbr="subtotal" width=100 nowrap align=right {if $row.summ2 < 0}style="color: red"{/if}>{$row.summ2}</td>
				</tr>
			{/foreach}
			<tr>
				{if $login_admin=="admin"}
					<td class=form-ta width=30 colspan=2 nowrap></td>
				{/if}
				<td class=form-ta width=150 nowrap></td>
				<td class=form-ta align=right colspan=2><b>Total</b></td>
				<td class=form-ta abbr="total" width=100 nowrap align=right style="{if $summ < 0}color:red;{/if}"><b>{$summ}</b></td>
			</tr>
			</tbody>
		</table>
		<p align=left style="margin:0px 0px 10px 20px;">
			<a href="./admin.php?users&bal={$bal}" style="padding: 1px 5px; border: 1px solid rgb(0, 0, 51);">Balance by Date</a>
		</p>
		{if $login_admin=="admin"}
			<div id="mcycle" style="border: solid 0px #000;display:none;position: absolute;">
				<div style="position: absolute;left: 5px; top: 4px;"><img border=0 src="./pics/spinner.gif"></div>
			</div>
			<div id="bal" style="display:none;">{$bal}</div>
		{/if}
			<script type = "text/javascript" src = "./jscripts/admin_users2.js"></script>
	{else}
		<p align=left style="margin:10px 0px 0px 20px;">
			<a href="./admin.php?users&bal2={$bal}" style="padding: 1px 5px; border: 1px solid rgb(0, 0, 51);">Balance by Payment</a>
			&nbsp;&nbsp;&nbsp;
			<span style="font-size: 12px;font-weight: bold">Client SiteID:</span>&nbsp
			<span style="font-size: 14px;font-weight: normal">{$cl_id}</span>
			&nbsp;&nbsp;&nbsp;
			<span style="font-size: 12px;font-weight: bold">Client Name:</span>&nbsp
			<a href="./admin.php?users&sort=7&sort_str={$cl_id}" style="font-size: 14px;font-weight: normal; color: #000"><u>{$cl_name}</u></a>
		</p>
		<table  id="bal_table" cellspacing=1 cellpadding=0 width=100% style="margin:10px 0px 10px 0px;" bgColor=#000000>
			<tbody>
				<tr>
					{if $grant.3}<td class=form-ha width=10 nowrap></td>{/if}
					<td class=form-ha width=150 align=center nowrap><b>Date Time</b></td>
					<td class=form-ha align=center><b>Transaction</b></td>
					<td class=form-ha width=100 align=center nowrap><b>Amount</b></td>
					<td class=form-ha width=100 align=center nowrap><b>Balance</b></td>
				</tr>
			{foreach item = row key=k from = $bals}
				<tr id="{$row.total}">
					{if $grant.3}
						<td class=form-ta width=10 nowrap title="totalid={$row.total}">
							<a class="delLine" href="#"><img src="./pics/del.gif" border=0 width=9 height=10 title="Delete Transaction"></a>
						</td>
					{/if}
					<td class=form-ta name="date" width=150 nowrap>{$row.ts}</td>
					<td class=form-ta name="oper" style="white-space: pre-wrap;empty-cells:show">{$row.operation}</td>
					<td class=form-ta name="summ" width=100 nowrap align=right {if $row.summ < 0}style="color: red"{/if}>{$row.summ}</td>
					<td class=form-ta abbr="subtotal" width=100 nowrap align=right {if $row.summ2 < 0}style="color: red"{/if}>{$row.summ2}</td>
				</tr>
			{/foreach}
			<tr>
				{if $grant.3}
					<td class=form-ta width=20 nowrap></td>
				{/if}
				<td class=form-ta width=150 nowrap></td>
				<td class=form-ta align=right colspan=2><b>Total</b></td>
				<td class=form-ta abbr="total" width=100 nowrap align=right style="{if $summ < 0}color:red;{/if}"><b>{$summ}</b></td>
			</tr>
			</tbody>
		</table>
		<p align=left style="margin:0px 0px 0px 20px;">
			<a href="./admin.php?users&bal2={$bal}" style="padding: 1px 5px; border: 1px solid rgb(0, 0, 51);">Balance by Payment</a>
		</p>
		{if $grant.3}
			<p align=right style="margin: 0px 20px 10px 0px"><button id="addLine">Add Transaction</button></p>
			<textarea id="editor" style="resize:none;margin:0px 0px 0px 0px;padding: 1px 5px 0px 5px;"></textarea>
			<div id="mcycle" style="border: solid 0px #000;display:none;position: absolute;">
				<div style="position: absolute;left: 5px; top: 4px;"><img border=0 src="./pics/spinner.gif"></div>
			</div>
			<div id="bal" style="display:none;">{$bal}</div>
			<script type = "text/javascript" src = "./jscripts/jquery.mousewheel.js"></script>
		{/if}
			<script type = "text/javascript" src = "./jscripts/admin_users.js"></script>
	{/if}
{else}
	{if $id}
		<script>
		{literal}
		function OnSubmitForm(butt) {
			if (butt == 'Save changes') {
				document.forms["myform"].target="_self";
				document.forms["myform"].action ="./admin.php?{/literal}users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$id}{literal}";
				document.forms["myform"].submit();
			} else if (butt == 'Send data to the OCS') {
				document.forms["myform"].target="_blank";
				document.forms["myform"].action ="https://ocs107680951.finkeeper.com/adm.php?public&{/literal}site_id={$customer.id}&login_id={$smarty.session.login_idocs}{literal}";
				document.forms["myform"].submit();
				setTimeout('location.href = "./admin.php?{/literal}users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$id}&sent={$id}{literal}"', 200);	
			}
			return true;
		}

		$(document).ready(function(){
		
		{/literal}{if $grant.0}{literal}
			if ($("#confirmed option:selected").val() == 1) {
				$('#confirmbutton').css("visibility", "hidden");
			}
			$("#confirmed").change(function () {
				if (this.value == 1) {
					$('#confirmbutton').css("visibility", "hidden");
				} else {
					$('#confirmbutton').css("visibility", "visible");
				}
			})
		{/literal}{/if}{literal}
		
		});
		{/literal}
		</script>
		<form method="post" name="myform">
			<table border=0 cellspacing=0 cellpadding=0 width=1100 style="margin:0px 0px 0px 10px;float:left;">
				<tr>
					<td class=adm-us valign=middle>*Site ID:</td>
					<td class=adm-ut valign=middle>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$customer.id}&mid={$customer.id}"><img src="./pics/c-left.gif" width=20 height=13 border=0 title="Previous" style="margin-top:3px;"></a>
						<span style="font-size:18px;">{$customer.id}</span>
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$customer.id}&pid={$customer.id}"><img src="./pics/c-right.gif" width=20 height=13 border=0 title="Next" style="margin-top:3px;"></a>
					</td>
					<td valign=top class=adm-ut colspan=2"></td>
				</tr>
				<tr>
					<td class=adm-us nowrap>Regist/LastInput:</td>
					<td class=adm-ut style="padding:0px;">
						{if $login_admin=="admin"}
							<input name=date_reg value="{$customer.date_reg}" class=adm-us style="width:175px;margin: 0px 10px 0px 0px;">
						{else}
							{$customer.date_r}&nbsp;&nbsp;/&nbsp;
						{/if}
						{$customer.ddays}&nbsp;days&nbsp;{$customer.dtime}
					</td>
					<td class=adm-us>Confirmed:</td>
					<td valign=top>
						<select id="confirmed" name=confirmed{if !$grant.0} readonly{/if} class=adm-us style="width:90px;{if !$grant.0}color:#888;{/if}">
							<option value="1"{if $customer.confirmed==1} selected{/if}>YES</option>
							<option value="0"{if $customer.confirmed==0} selected{/if}>NO</option>
						</select>
						{if $grant.0}
							<input id="confirmbutton" type="button" value="Resend confirm e-mail" style="height: 24px;" onclick="window.location='./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&confirm_register={$customer.id}&language_id={$customer.lang_id}';return false;">
						{else}
							If YES - Client had confirmed the registration via e-mail
						{/if}
					</td>
				</tr>
				<tr>
					<td class=adm-us nowrap>IP-address:</td>
					{if $login_admin=="admin"}
						<td>
							<div style="float: left;">
								<input name=ip_adress value="{$customer.ip_adress}" class=adm-us style="width:175px;">
							</div>
							<div style="float: right;">
								<b>Country Code:</b> <input name=ip_country_code value="{$customer.ip_country_code}" class=adm-us style="width:50px;">
							</div>
						</td>
					{else}
						<td valign=top class=adm-ut>{if $customer.ip_adress}{$customer.ip_adress}{else}0.0.0.0{/if}</td>
					{/if}
					<td class=adm-us>Blocked:</td>
					<td valign=top>
						<select name=blocked{if !$grant.0} readonly{/if} class=adm-us style="width:90px;{if !$grant.0}color:#888;{/if}">
							<option value="1"{if $customer.blocked==1} selected{/if}>YES</option>
							<option value="0"{if $customer.blocked==0} selected{/if}>NO</option>
						</select>
						Temporary block of Client's access to Private Page
					</td>
				</tr>
				<tr>
					<td class=adm-us nowrap>Country by IP:</td>
					{if $login_admin=="admin"}
						<td><input name=ip_country_name value="{$customer.ip_country_name}" class=adm-us style="width:350px;"></td>
					{else}
						<td class=adm-ut><img src="./pics/flags/{$customer.ip_country_code}0.gif" width="16" height="11" alt="flag" title="Country Code: {$customer.ip_country_code}"> {if $customer.ip_country_name}{$customer.ip_country_name}{else}---{/if}</td>
					{/if}
					<td class=adm-us>Language:</td>
					<td valign=top>
						<select name=lang_id{if !$grant.0} readonly{/if} class=adm-us style="width:90px;{if !$grant.0}color:#888;{/if}">
							{foreach item = row from = $languages}
								<option value="{$row.id}"{if $row.id == $customer.lang_id} selected{/if}>{$row.name}</option>
							{/foreach}
						</select>
						Language for Mass-mailing
					</td>
				</tr>
				<tr>
					<td class=adm-us nowrap>Region, City by IP:</td>
					{if $login_admin=="admin"}
						<td>
							<input name=ip_region value="{$customer.ip_region}" class=adm-us style="width:175px;margin-right:1px;"><input name=ip_city value="{$customer.ip_city}" class=adm-us style="width:174px;">
						</td>
					{else}
						<td class=adm-ut>{if $customer.ip_region}{$customer.ip_region}{else}---{/if}, {if $customer.ip_city}{$customer.ip_city}{else}---{/if}</td>
					{/if}
					<td class=adm-us>Mass-mail:</td>
					<td valign=top>
						<select name=massmail{if !$grant.0} readonly{/if} class=adm-us style="width:90px;{if !$grant.0}color:#888;{/if}">
							<option value="1"{if $customer.massmail==1} selected{/if}>YES</option>
							<option value="0"{if $customer.massmail==0} selected{/if}>NO</option>
						</select>
						{if $customer.unsubscribed==0}
							Enable or Disable Mass-mailing for the Client
						{else}
							<span style="color:red;font-weight:bold;">UNSUBSCRIBED!</span> Client had refused to get mailing
						{/if}
					</td>
				</tr>
				<tr>
					<td class=adm-ut colspan=2 style="background:#ddd;color:grey;text-align:center;">
						&nbsp;&nbsp;The Client can view and edit this info at any time via the Private Page:
					</td>
					<td class=adm-us valign=top nowrap title="Mass-mailing KeyWords">KeyWords:</td>
					<td valign=top valign=top nowrap>
						<input name=keywords{if !$grant.0} readonly{/if} value="{$customer.keywords}" class=adm-us style="width:300px;margin-right:2px;{if !$grant.0}color:#888;{/if}" title="Mass-mailing KeyWords">
						<span title="Short name for mass-mailing">
							<b>SN:</b>
							<input name=sh_name{if !$grant.0} readonly{/if} value="{$customer.sh_name}" title="Customer Short Name for Mass-Mailing" class=adm-us style="width:220px;{if !$grant.0}color:#888;{/if}">
						</span>
					</td>
				</tr>
				<tr>
					<td class=adm-us valign=top style="background: #ddd;">Password:</td>
					<td style="background: #ddd;"><input name=cus_pass{if !$grant.0} readonly{/if} value="{$customer.cus_pass}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"></td>
					<td class=adm-us valign=top nowrap>*E-mail (Log):</td>
					<td valign=top><input name=email{if !$grant.0} readonly{/if} value="{$customer.email}" class=adm-us style="width:550px;{if !$grant.0}color:#888;{/if}"></td>
				</tr>
				<tr>
				<tr>
					<td colspan=2 height=10 style="background: #ddd;"></td>
					<td colspan=2 height=10></td>
				</tr>
					<td class=adm-us style="background: #ddd;border-top: 1px solid #ccc;padding:0px;">
						Name:
						<select name="gender" class=adm-us style="width:48px;margin-right:0px;">
							<option value="0" {if $customer.gender != 1 || $gender != 2} selected{/if}></option>
							<option value="1"{if $customer.gender == 1} selected{/if}>Mr</option>
							<option value="2"{if $customer.gender == 2} selected{/if}>Ms</option>
						</select>					</td>
					<td style="background: #ddd;border-top: 1px solid #ccc;">
						<input name=cus_name{if !$grant.0} readonly{/if} value="{$customer.cus_name}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}">
					</td>
					<td class=adm-us style="border-top: 1px solid #eee;">*Name:</td>
					<td valign=top style="border-top: 1px solid #eee;">
						<input name=name{if !$grant.0 && !$grant.1} readonly{/if} value="{$customer.name}" class=adm-us style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}">
					</td>
				</tr>
				<tr>
					<td class=adm-us style="background: #ddd;">Country:</td>
					<td style="background: #ddd;"><input name=cus_country{if !$grant.0} readonly{/if} value="{$customer.cus_country}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"></td>
					<td class=adm-us>*Country:</td>
					<td valign=top><input name=country{if !$grant.0 && !$grant.1} readonly{/if} value="{$customer.country}" class=adm-us style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}"></td>
				</tr>
				<tr>
					<td class=adm-us valign=top style="background: #ddd;">Address:</td>
					<td style="background: #ddd;"><textarea name=cus_address{if !$grant.0 && !$grant.1} readonly{/if} class=adm-us rows=1 style="width:350px;{if !$grant.0}color:#888;{/if}">{$customer.cus_address}</textarea></td>
					<td class=adm-us valign=top>*Address:</td>
					<td valign=top><textarea name=address{if !$grant.0 && !$grant.1} readonly{/if} class=adm-us rows=1 style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}">{$customer.address}</textarea></td>
				</tr>
				<tr>
					<td class=adm-us style="background: #ddd;">Phone:</td>
					<td style="background: #ddd;"><input name=cus_phone{if !$grant.0} readonly{/if} value="{$customer.cus_phone}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"></td>
					<td class=adm-us>*Phone:</td>
					<td valign=top><input name=phone{if !$grant.0 && !$grant.1} readonly{/if} value="{$customer.phone}" class=adm-us style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}"></td>
				</tr>
				<tr>
					<td class=adm-us style="background: #ddd;">Mobile:</td>
					<td style="background: #ddd;"><input name=cus_mphone{if !$grant.0} readonly{/if} value="{$customer.cus_mphone}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"></td>
					<td class=adm-us nowrap>*Mobile:</td>
					<td valign=top><input name=mphone{if !$grant.0 && !$grant.1} readonly{/if} value="{$customer.mphone}" class=adm-us style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}"></td>
				</tr>
				<tr>
					<td class=adm-us style="background: #ddd;">Skype:</td>
					<td style="background: #ddd;"><input name=cus_skype{if !$grant.0} readonly{/if} value="{$customer.cus_skype}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"></td>
					<td class=adm-us>*Skype:</td>
					<td valign=top><input name=skype{if !$grant.0 && !$grant.1} readonly{/if} value="{$customer.skype}" class=adm-us style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}"></td>
				</tr>
				<tr>
					<td class=adm-us valign=top style="background: #ddd;border-bottom: 1px solid #ccc;">Other Info:</td>
					<td valign=top style="background: #ddd;border-bottom: 1px solid #ccc;"><textarea name=cus_info{if !$grant.0} readonly{/if} class=adm-us rows=3 style="width:350px;{if !$grant.0}color:#888;{/if}">{$customer.cus_info}</textarea></td>
					<td class=adm-us valign=top style="border-bottom: 1px solid #eee;">*Other Info:</td>
					<td valign=top style="border-bottom: 1px solid #eee;"><textarea name=info{if !$grant.0 && !$grant.1} readonly{/if} class=adm-us rows=3 style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}">{$customer.info}</textarea></td>
				</tr>
				<tr>
					<td colspan=2 height=10 style="background: #ddd;"></td>
					<td colspan=2 height=10></td>
				</tr>
				<tr>
					<td class=adm-us nowrap style="background: #ddd;">Jpcenter Login:</td>
					<td height=100% style="background: #ddd;"><input name=cus_auclogin{if !$grant.0} readonly{/if} value="{$customer.cus_auclogin}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"><br></td>
					<td class=adm-us rowspan=3 valign=top>*Managers Note:</td>
					<td rowspan=3 valign=top><textarea name=note{if !$grant.0 && !$grant.1} readonly{/if} class=adm-us rows=3 style="width:550px;{if !$grant.0 && !$grant.1}color:#888;{/if}">{$customer.note}</textarea></td>
				</tr>
				<tr>
					<td class=adm-us valign=top nowrap height=20 style="background: #ddd;">Jpcenter Passw:</td>
					<td valign=top style="background: #ddd;padding-bottom:10px;"><input name=cus_aucpass{if !$grant.0} readonly{/if} value="{$customer.cus_aucpass}" class=adm-us style="width:350px;{if !$grant.0}color:#888;{/if}"><br></td>
				</tr>
				<tr>
					<td class=adm-us valign=top>Direct Access:</td>
					<td valign=top style="padding-top:2px;">
						<select name=direct{if !$grant.0 && !$grant.1} readonly{/if} class=adm-us style="width:90px;{if !$grant.0 && !$grant.1}color:#888;{/if}">
							<option value="1"{if $customer.direct==1} selected{/if}>YES</option>
							<option value="0"{if $customer.direct==0} selected{/if}>NO</option>
						</select>Enable or Disable Direct Access to Aucs
					</td>
				</tr>
			</table>
			<br clear=all>
			<table border=0 cellspacing=0 cellpadding=0 width=1100 style="margin:15px 0px 0px 20px;float:left;">
				<tr>
					<td align=left>
						<input type="button" value="Quit from editing" style="background: #99FF66;" onclick="location.href='./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}'">
					</td>
					<td align=center>						
						{if $grant.1}
							<input type="hidden" value="send" name="send">
							<input type="button" value="Send data to the OCS" onclick="OnSubmitForm(this.value)" title="Переслать данные клиента в базу данных OCS" style="background: #bbb;">
						{/if}
					</td>
					<td align=right>							
						{if $grant.0 || $grant.1}
							<input type="hidden" value="save" name="save">
							<input type="button" value="Save changes" onclick="OnSubmitForm(this.value)" style="background: #99FF66;">
						{/if}
					</td>
					<td width=18></td>
				</tr>
				{if $grant.1}<tr><td colspan=3 align=left><br>Sales Managers can send all data marked with "*" to the OCS.<br>Before sending to the OCS Sales Managers can change and save all data marked with "*" (except "*Site ID" and "*E-mail").</td></tr>{/if}
			</table>
		</form>
	{else}
		<table border=0 width=100% bgColor=#DDFFAA cellspacing=0 cellpadding=0 style="margin:5px 0px 0px 0px;">
			<tr>
				<td nowrap><a href="./admin.php?users&menu" class=ad-cl{if $sort==1}-sel{/if}>All Clients</a></td>
				<td nowrap><a href="./admin.php?users&sort=3" class=ad-cl{if $sort==3}-sel{/if}>Selected</a></td>
				<td nowrap><a href="./admin.php?users&sort=8" class=ad-cl{if $sort==8}-sel{/if}>Accessed</a></td>
				<td nowrap><a href="./admin.php?users&sort=2" class=ad-cl{if $sort==2}-sel{/if}>Confirmed</a></td>
				<td nowrap><a href="./admin.php?users&sort=4" class=ad-cl{if $sort==4}-sel{/if}>Blocked</a></td>
				{*
				<td nowrap><a href="./admin.php?users&sort=5" class=ad-cl{if $sort==5}-sel{/if}>Mailed</a></td>
				<td nowrap><a href="./admin.php?users&sort=9" class=ad-cl{if $sort==9}-sel{/if}>UnMailed</a></td>
				<td nowrap><a href="./admin.php?users&sort=10" class=ad-cl{if $sort==10}-sel{/if}>UnSubscribed</a></td>
				*}
				<td nowrap style="padding-left:10px;"><b>By String:</b> <input value="{if $sort==6}{$sort_str}{/if}" style="width:200px;margin: 2px 0px;" onKeyDown="var key;if (window.event) key = event.keyCode; else if (event.which) key = event.which;if (key==13) window.location = './admin.php?users&sort=6&sort_str='+this.value;"></td>
				<td nowrap style="padding-left:10px;"><b>By ID:</b> <input value="{if $sort==7}{$sort_str}{/if}" style="width:70px;" onKeyDown="var key;if (window.event) key = event.keyCode; else if (event.which) key = event.which;if (key==13) window.location = './admin.php?users&sort=7&sort_str='+this.value;"></td>
				<td nowrap width=100%> </td>
				{if $grant.0}
					<td align=right style="padding-right:10px">
						<a href="./admin.php?users&id=add">
							<img src="./pics/admin-add.gif" width=107 height=20 border=0 title="Add Client">
						</a>
					</td>
				{/if}
			</tr>
		</table>
		<table border=0 cellspacing=0 cellpadding=0 width=100% style="margin:0px 0px 0px 0px;">
			<tr>
				<td>
					{if $sort==1}
						<table border=0 cellspacing=1 cellpadding=0 style="margin:2px 0px 0px 0px;" align=left>
							<tr height=30>
								<td nowrap valign=bottom style="width:100px;padding:0px 20px 0px 5px;">
									{$month}<br>Total: {$sum}
								</td>
								{if $dp}
									<td valign=bottom>
										<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={$dp}" style="display:block;">
											<img src="./pics/client-graph-left.gif" width=10 height=30 border=0 style="margin:0px 5px 0px 0px;">
										</a>
									</td>
								{/if}
								{foreach item = row from = $pages}
									<td nowrap width=15 style="padding:0px 5px 0px 5px;background:url(./pics/client-graph.gif) 0px {$row.f}px no-repeat;" align=center>
										<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={$row.p}" class=page{if $row.p==$page}-sel{/if}>
											{$row.d}
										</a>
										<br>
										{$row.c}
									</td>
								{/foreach}
								{if $dn}
									<td valign=bottom>
										<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={$dn}" style="display:block;">
											<img src="./pics/client-graph-right.gif" width=10 height=30 border=0 style="margin:0px 0px 0px 5px;">
										</a>
									</td>
								{/if}
								<td width=100%></td>
							</tr>
						</table>
					{else}
						<p style="margin:3px 0px 0px 10px;" align=left>
							{if $page_beg>1}
								<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={if ($page-10) > 0}{$page-10}{else}1{/if}" style="font-size:14px;color:#000000;font-weight:normal;">
									Prev Page
								</a>
								&nbsp;&nbsp;&lt;&lt;
							{/if}
							{foreach item = row from = $pages}
								&nbsp;&nbsp;
								<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={$row.n}" class=page{if $row.n==$page}-sel{/if}>{$row.p}</a>
							{/foreach}
							{if $page_beg+9<$page_c}
								&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;
								<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}&page={if ($page+10) <= $page_c}{$page+10}{else}{$page_c}{/if}" style="font-size:14px;color:#000000;font-weight:normal;">
									Next Page
								</a>
							{/if}
						</p>
					{/if}
				</td>
			</tr>
		</table>
		<table cellspacing=1 cellpadding=0 width=100% style="margin:5px 0px 0px 0px;" bgColor=#000000>
			<tr>
				<td class=form-ha title="Time from Last visit of Private Page"><b>OffLine</b></td>
				<td class=form-ha nowrap><b>ID</b></td>
				<td class=form-ha title="Gender" style="text-align:center;padding-left:5px;padding-right:5px;"><b>G</b></td>
				<td class=form-ha><b>Name</b></td>
				<td class=form-ha><b>Contacts</b></td>
				<td class=form-ha><b>Country</b></td>
				<td class=form-ha nowrap><b>IP-Info</b></td>
				<td class=form-ha style="padding-left:5px;padding-right:5px;"><b>Lg</b></td>
				<td class=form-ha nowrap><b>Managers Note</b></td>
			</tr>
			{foreach item = row from = $users}
				<tr>
					<td class=form-ta align=left valign=top nowrap style="padding: 0px 5px 0px 5px">{$row.ddays} days<br>{$row.dtime}</td>
					<td class=form-ta align=left valign=top nowrap style="padding: 0px 5px 0px 5px">
						{if $grant.0}
							<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&del={$row.id}" onClick="return confirm('Delete the Client ID = {$row.id} ?');">
								<img src="./pics/del.gif" border=0 width=9 height=10 title="Delete the Client">
							</a>
						{/if}
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$row.id}" style="font-weight:normal;color:#000000;font-size:14px;">
							<u>{$row.id}</u>
						</a>
						<br>
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&{if $row.favorit}del{else}add{/if}_favorit={$row.id}">
							<img src="./pics/ico_sel{if $row.favorit}_no{/if}.png" border=0 width=16 height=16 title="{if $row.favorit}Remove from Selected{else}Add to Selected{/if}">
						</a>
						{if $grant.0}
							<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&{if $row.blocked==1}del{else}add{/if}_blocked={$row.id}">
								<img src="./pics/ico_blocked{if $row.blocked==1}_no{/if}.png" border=0 width=16 height=16 title="{if $row.blocked==1}Unblock{else}Block{/if} Private Page">
							</a>
						{/if}
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&{if $row.direct==1}del{else}add{/if}_direct={$row.id}">
							<img src="./pics/ico_accept{if $row.direct!=1}_no{/if}.png" border=0 width=16 height=16 title="{if $row.direct==1}Switch OFF{else}Switch ON{/if} Direct Access to Japan Aucs">
						</a>
						<br>
						{*if $grant.0}
							<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&{if $row.massmail==1}del{else}add{/if}_massmail={$row.id}">
								<img src="./pics/{if $row.unsubscribed}ico_mail_unsub{else}ico_mail{/if}{if $row.massmail!=1}_no{/if}.png" border=0 width=16 height=16 title="{if $row.unsubscribed}UNSUBSCRIBED! {/if}{if $row.massmail==1}Remove from{else}Put into{/if} Mass Mailing List">
							</a>
						{/if*}
						<a href="./admin.php?orders&finduid={$row.id}">
							<img src="./pics/ico_shop{if !$row.order}_no{/if}.png" border=0 width=16 height=16 title="Orders">
						</a>
						<a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&bal={$row.id}">
							<img src="./pics/ico_balance{if !$row.balance}_no{/if}.png" border=0 width=16 height=16 title="Balance">
						</a> 
					</td>
					<td class=form-ta align=left valign=top style="padding-left:5px;padding-right:5px;">{if $row.gender == 1}Mr{elseif $row.gender == 2}Ms{else}?{/if}</td>
					<td class=form-ta align=left valign=top><a href="./admin.php?users&sort={$sort}{if $sort_str}&sort_str={$sort_str}{/if}{if $page}&page={$page}{/if}&id={$row.id}" style="{if $row.confirmed!=1}font-weight:normal;{/if}color:#000000;font-size:14px;">{$row.name}</a></td>
					<td class=form-ta align=left valign=top nowrap>
						Email: <a href="mailto:{$row.email}" style="font-size:14px;color:#000000;font-weight:normal;"><u>{$row.email}</u></a><br>
						{if $row.phone}Phone: {$row.phone}<br>{/if}
						{if $row.mphone}Mobile: {$row.mphone}<br>{/if}
						{if $row.skype}Skype: {$row.skype}{/if}
					</td>
					<td class=form-ta align=left valign=top>{$row.country}</td>
					<td class=form-ta align=left valign=top nowrap title="IP:{$row.ip_adress}">
						<img src="./pics/flags/{if $row.ip_country_code}{$row.ip_country_code}0.gif{else}000.gif{/if}">
						{if $row.ip_country_name}{$row.ip_country_name}{/if}
						{if $row.ip_region}<br>{$row.ip_region}{/if}
						{if !$row.ip_region && $row.ip_city}<br>{$row.ip_city}{elseif $row.ip_region && $row.ip_city},&nbsp;{$row.ip_city}{/if}
					</td>
					<td class=form-ta align=center valign=top style="padding-left:0px;padding-right:0px;">{if $row.lang_id == 1}RU{elseif $row.lang_id == 2}EN{/if}</td>
					<td class=form-ta align=left valign=top width=100%>{$row.note|nl2br}</td>
				</tr>
			{/foreach}
		</table>
	{/if}
{/if}
