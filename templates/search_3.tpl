<div class="container min-h-500 w"> 
	<div class="row">
		<div clas="col-xl-12 col-lg-12 w">

<p style="font-size:14px;margin:10px 10px 10px 10px;">
    <span class=nav>{$content_3}</span>
</p>
{if $err}
	{$err}
{else}
	{if $lotid || $lotidst}
		{literal}
		<script type="text/javascript">
		  function setBigImage(foto) {
			document.getElementById("bigimg").src = foto.src;
			document.getElementById("hrf").href = foto.src;
		  }
		</script>
		{/literal}
		<a href="./index.php?search_3&page={$page}{if $stats}&stats=yes{else}&ssearch=yes{/if}">&nbsp;{$content_183}</a>
		<table border = 0 width = 100% style = "text-align: center; margin: 0px 0px 0px 0px;">
			{if $idres}
				<tr>
					<td colspan=3 width = 500 >
							{if $direct_user}
								<a href="{$pictures.1}" id="hrf" target=_blank><img id ="bigimg" src="{$pictures.1}" border=1 width = 500 alt = "&nbsp;{$content_374}&nbsp;" /></a>
							{else}
								<img id = "bigimg" src="{$pictures.1}" border=1 width = 500 alt = "&nbsp;{$content_374}&nbsp;" />
							{/if}
					</td>
					<td colspan = 2 align=left valign="top" width = 500 style = "padding: 0px 0px 0px 10px;">
						<FONT size="5" color="#009900">{if $idres}{$idres.0.MARKA_NAME}<br>{$idres.0.MODEL_NAME}{else}DATA NOT FOUND{/if}</FONT><br><br>
							<b>{$content_156}:</b> {$idres.0.LOT}<br>
							<b>{$content_148}:</b> {$idres.0.AUCTION}<br>
							<b>{$content_167}:</b> {if $login_user}{$idres.0.AUCTION_DATE}{else}<FONT color="#ff0000">{$content_188}</FONT>{/if}<br>
							<b>{$content_169}:</b> {$idres.0.YEAR}<br>
							<b>{$content_178}:</b> {$idres.0.ENG_V}<br>
							<b>{$content_170}:</b> {$idres.0.KUZOV}<br>
							<b>{$content_171}:</b> {if $login_user}{$idres.0.GRADE}{else}<FONT color="#ff0000">{$content_188}</FONT>{/if}<br>
							<b>{$content_173}:</b> {$idres.0.COLOR}<br>
							<b>{$content_177}:</b> {$idres.0.KPP}<br>
							<b>{$content_174}:</b> {$idres.0.PRIV}<br>
							<b>{$content_179}:</b> {$idres.0.MILEAGE}<br>
							<b>{$content_172}:</b> {if $login_user}{$idres.0.EQUIP}{else}<FONT color="#ff0000">{$content_188}</FONT>{/if}<br>
							<b>{$content_180}:</b> {$idres.0.RATE}<br>
							<b>{$content_181}:</b> {$idres.0.START}<br>
							<b>{$content_182}:</b> {if $direct_user}{$idres.0.FINISH}{else}<FONT color="#ff0000">{$content_189}</FONT>{/if}<br>
							<b>{$content_184}:</b> {if $direct_user}{$idres.0.STATUS}{else}<FONT color="#ff0000">{$content_189}</FONT>{/if}<br>
							<b>{$content_185}:</b> {if $login_user}{$idres.0.AVG_PRICE}{else}<FONT color="#ff0000">{$content_188}</FONT>{/if}<br>
							<b>{$content_186}:</b> {if $login_user}{$idres.0.INFO}{else}<FONT color="#ff0000">{$content_188}</FONT>{/if}<br>
							{if $login_user}{$idres.0.SERIAL}{/if}<br>
					</td>
				</tr>
				<tr>
					<td width = 160>
						<img src="{$pictures.1}" border=1 width = 162 onclick = 'setBigImage(this)' alt = '&nbsp;{$content_374}&nbsp;' />
					</td>
					<td width = 160>
						<img src="{$pictures.2}" border=1 width = 162 onclick = 'setBigImage(this)' alt = '&nbsp;{$content_374}&nbsp;' />
					</td>
					<td width = 160>
						<img src="{$pictures.3}" border=1 width = 162 onclick = 'setBigImage(this)' alt = '&nbsp;{$content_374}&nbsp;' />
					</td>
					{if $login_user && !$lotidst}
						<form action = "./index.php?search_3" method = "post" onSubmit="var v = '{$content_373}';{literal}if (!this.request.value) { alert(v); return false; } return true;{/literal}">
							<td align=right>
								<textarea name=request style="border:1px solid #000000;margin:0px 0px 0px 0px;padding:5px;width:330px;height:120px;resize:none;"></textarea>
							</td>
							<td>
								<input type="submit" name="send" value="{$content_187}" style="height:65px;width:105px;background: #99ff66;margin:0px;padding:0px;">
							</td>
							<input type=hidden name=mlotid value={$lotid}>
						</form>
					{elseif !$lotidst}
						<td></td>
						<td>
							<FONT size=4 color="#ff0000">{$content_190}</FONT><br>
							<FONT size=4>{$content_191} <a href="./index.php?registr" style="font-size:16px;font-weight:bold;">{$content_192}</a></FONT><br>
							<FONT size=4>{$content_193} <a href="./index.php?login" style="font-size:16px;font-weight:bold;">{$content_192}</a></FONT>
						</td>
					{elseif $lotidst}
						<td></td>
						<td>
							<FONT size=4 color="#ff0000">{$content_326}</FONT><br>
							<FONT size=4>{$content_359}<br>
							{$content_360} <a href = "mailto:sales@carvector.com" style="font-size:16px;font-weight:bold;">sales@carvector.com</a></FONT><br>
						</td>
					{/if}
				</tr>
				<tr>
					<td colspan=3 align=center width = 500 style = "padding: 0px 0px 0px 0px;">
						{if $login_user}
							{if $direct_user}
								<a href="{$pictures.0}" target=_blank><img src="{$pictures.0}" border=1 width = '500' alt = "&nbsp;{$content_374}&nbsp;"></a>
							{else}
								<img src="{$pictures.0}" border=1 width = '500' alt = "&nbsp;{$content_374}&nbsp;">
							{/if}
						{else}
							<FONT color="#ff0000">{$content_194}</FONT>
						{/if}
					</td>
					<td colspan = 2 align=left style = "padding: 5px 0px 0px 5px;">
						{$content_195}<br>
						{$content_196}<br>
						{$content_197}<br>
						{$content_198}<br>
						{$content_199}<br>
						{$content_200}<br>
						{$content_201}<br>
						{$content_202}<br>
						{$content_203}<br>
						{$content_204}<br>
						{$content_205}<br>
						{$content_206}<br>
						{$content_207}<br>
						{$content_208}<br>
						{$content_209}<br>
						{$content_210}<br>
						{$content_211}<br>
						{$content_212}<br>
						{$content_213}<br>
						{$content_214}<br>
						{$content_215}<br>
						{$content_216}<br>
						{$content_217}<br>
						{$content_218}<br>
						{$content_219}<br>
						{$content_220}<br>
						{$content_221}
					</td>
				</tr>
			{else}
				<tr>
					<td colspan = 2 align=center valign="top" width = 500 style = "padding: 0px 0px 0px 10px;font-size:24px;color:#009900;">
						DATA NOT FOUND
					</td>
				</tr>
			{/if}
		</table>
	{else}
		<table border=0 width=100%>
		<form method="post" action ="./index.php?search_3" >
			<tr><td>
				<table border=0>
					<tr>
						<td>
						<table border=0 bgcolor=#99ff66>
							<tr class="curdef">
								<td style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_144}</td>
								<td style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_145}</td>
								<td style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_146} ID <span title="{$content_147}">[?]</span></td>
								<td style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_148} <span title="{$content_147}">[?]</span></td>
								<td style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_149} <span title="{$content_147}">[?]</span></td>
								<td colspan=2 style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_150}</td>
							</tr>
							<tr>
								<td rowspan=7 valign="top">
								   <select size=8 name=marka_id style="width:143px;" onchange="this.form.submit()">
										{foreach item = row from = $marka}
										<option value="{$row.MARKA_ID}"{if $row.MARKA_ID == $selmarka_id} selected{/if}>{$row.MARKA_NAME}</option>
										{/foreach}
									</select>
								</td>
								<td rowspan=7 valign="top">
								   <select size=8 name=model_id style="width:200px;" onchange="this.form.submit()">
										{foreach item = row from = $model}
										<option value="{$row.MODEL_ID}"{if $row.MODEL_ID == $selmodel_id} selected{/if}>{$row.MODEL_NAME}</option>
										{/foreach}
									</select>
								</td>
								<td rowspan=7 valign="top">
								   <select size=8 name=kuzov[] multiple style="width:110px;">
										{foreach item = row key = k from = $chas}
										<option value="{$row.KUZOV}"{if in_array($row.KUZOV, $selkuzovarr)} selected{/if}>{$row.KUZOV}</option>
										{/foreach}
									</select>
								</td>
								<td rowspan=7 valign="top">
								   <select size=8 name=aucs[] multiple style="width:170px;">
										{foreach item = row from = $aucs}
										<option value="{$row}"{if in_array($row, $aucarr)} selected{/if}>{$row}</option>
										{/foreach}
									</select>
								</td>
								<td rowspan=7 valign="top">
								   <select size=8 name=rates[] multiple style="width:70px;">
										{foreach item = row from = $rates}
										<option value="{$row}"{if in_array($row, $ratearr)} selected{/if}>{$row}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<select style="height:18px; width:67px; padding: 0px 0px 0px 0px;" name=year1>
										{foreach item = row from = $years}
										<option value="{$row}"{if $row == $selyear1} selected{/if}>{$row}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<select style="height:18px; width:67px; padding: 0px 0px 0px 0px;" name=year2>
										{foreach item = row from = $years}
										<option value="{$row}"{if $row == $selyear2} selected{/if}>{$row}</option>
										{/foreach}
									</select>
								</td>
							</tr>
							<tr>
								<td colspan=2 nowrap style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_151}</td>
							</tr>
							<tr>			
								<td><input style="height:18px; width:67px; padding: 0px 5px 0px 5px; text-align:right" name=mil1 value="{$mil1}"></td>
								<td><input style="height:18px; width:67px; padding: 0px 5px 0px 5px; text-align:right" name=mil2 value="{$mil2}"></td>
							</tr>
							<tr>
								<td colspan=2 nowrap style="cursor:default; height:15px; padding: 0px 0px 0px 2px;">{$content_152}</td>
							</tr>
							<tr>			
								<td><input style="height:18px; width:67px; padding: 0px 5px 0px 5px; text-align:right" name=eng1 value="{$eng1}"></td>
								<td><input style="height:18px; width:67px; padding: 0px 5px 0px 5px; text-align:right" name=eng2 value="{$eng2}"></td>
							</tr>
							<tr>			
								<td colspan=2>
									<select style="height:18px; width:137px; padding: 0px 0px 0px 0px;" name=kpp>
											<option value="">{$content_153}</option>
											<option value="aut"{if $kpp == "aut"} selected{/if}>{$content_154}</option>
											<option value="man"{if $kpp == "man"} selected{/if}>{$content_155}</option>
									</select>
								</td>			
							</tr>
							<tr>			
								<td colspan=2><input style="height:18px; width:137px; padding: 0px 5px 0px 5px; text-align:right" name=lotno value={if $lotno}"{$lotno}"{else}"{$content_156}"{/if} onclick="this.value='';" onfocus="this.value='';"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table border=0>
					<tr align=left>{*<!--это закрытый дивом дубликат кнопки SEARCH. ставим здесь, чтобы вызвать ее нажатие по Enter-->*}
						<td valign="top" align=center style="height: 60px; cursor:default;">
							<div style="position:relative;text-align: left;border: 0px solid #000;">
								<div style="position: absolute;text-align: center; width:95px; height: 50px;left:0px; top:0px;background: #fff">
									{$content_157}<br>{$content_158}<br><b>{$numlots}</b> {$content_159}
								</div>
							</div>
							<input type="submit" name="ssearch" value="SEARCH" />
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="{$content_160}" name="reset" style="width:95px;background: #99ff66;"></td>
					</tr>
					<tr>
						<td><input type="submit" value="{$content_161}" name="stats" style="width:95px;background: #99ff66;"></td>
					</tr>
					<tr>
						<td><input type="submit" value="{$content_162}" name="ssearch" style="height:45px; width:95px;font-weight: bold;background: #99ff66;"></td>
					</tr>
				</table>
			</td></tr>	
		</form>
		</table>
		{if $ssearch || $stats}
			<table border=0 width=100%>
				{if $stats}
					<tr>
						<td colspan=2 align=center style="font-size:16px;color:#000099;font-weight:bold;">
							{$content_222}
						</td>
					</tr>
				{/if}
				<tr>
					<td align=left>
						<b>{if $lotno}Lot {$lotno}{else}{$marka_name} {$model_name}{/if}</b> {$content_165} {$foundlots}{if $stats} {$content_223}{/if}
					</td>
					<td align=right>
						<table border=0 style="text-align:center; float:right; margin-right: 13px">
							<tr>
								{if $pagesarr[1]==".."}
									<td>
										<a href="./index.php?search_3&page={$prev_page}{if $stats}&stats=yes{else}&ssearch=yes{/if}" style="font-size:12px;color:#000;">
											<div style="padding: 0px 3px 0px 3px; color: #000; font-weight:bold; border: 1px solid #ddd;">
												{$content_163}
											</div>
										</a>
									</td>
								{/if}
								{foreach item = row key = k from = $pagesarr}
									<td>
										{if $row <> ".."}
											<a href="./index.php?search_3&page={$row}{if $stats}&stats=yes{else}&ssearch=yes{/if}" style="color: #000; font-weight:normal; font-size: 12px;">
												<div style="padding: 0px 3px 0px 3px;{if $row==$page} border: 1px solid #00dd00; background:#99FF66;{else} border: 1px solid #99FF66;{/if}">
													{$row}
												</div>
											</a>
										{else}
											<div style="padding: 0px 3px 0px 3px; color: #000; font-weight:normal; font-size: 12px;">
												{$row}
											</div>
										{/if}
									</td>
								{/foreach}
								{if $pagesarr[$blok]==".." || $pagesarr[$blok+2]==".."}
									<td>
										<a href="./index.php?search_3&page={$next_page}{if $stats}&stats=yes{else}&ssearch=yes{/if}" style="font-size:12px;color:#000;">
											<div style="padding: 0px 3px 0px 3px; color: #000; font-weight:bold; border: 1px solid #ddd;">
												{$content_164}
											</div>
										</a>
									</td>
								{/if}								
							</tr>
						</table>
						</td>
					</tr>
				</table>
			<table border=1 style="border-color: #434343;" cellspacing=1 cellpadding=0 width=100% bgColor=#00dd00>
					<tr>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_166}{if $login_user},<br>{$content_167}{/if}</td>
							<td class=form-ha width=50px align=center style="padding: 2px 5px 2px 5px;">{$content_168}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_169}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_170}{if $login_user}, {$content_171},<br>{$content_172}{/if}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_173}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_174}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_175}<br>{$content_176}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_178}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_179}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_180}</td>
							<td class=form-ha nowrap align=center style="padding: 2px 5px 2px 5px;">{$content_181}{if $direct_user}<br>{$content_182}{/if}</td>
					</tr>
					{foreach item = row from = $search_res}
					<tr>
							<td class=form-ta nowrap style="padding: 0px 5px 0px 5px;"><b><u><FONT COLOR="#009900"><a href={if $stats}"./index.php?search_3&lotidst={$row.ID}&stats=yes"{else}"./index.php?search_3&lotid={$row.ID}&ssearch=yes"{/if}>{$row.LOT}</a></FONT></u></b><br>{$row.AUCTION}<br>{if $login_user}<FONT COLOR="#999999">{$row.AUCTION_DATE}</FONT>{/if}</td>
							<td class=form-ta style="padding: 0px 0px 0px 1px;"><a href={if $stats}"./index.php?search_3&lotidst={$row.ID}&stats=yes"{else}"./index.php?search_3&lotid={$row.ID}&ssearch=yes"{/if}><img src="{$row.IMAGES}" border=1 height=50></a></td>
							<td class=form-ta align=right style="padding: 0px 5px 0px 5px;">{$row.YEAR}</td>
							<td class=form-ta style="padding: 0px 5px 0px 5px;">{if $lotno}{$row.MARKA_NAME} {$row.MODEL_NAME} {/if}{$row.KUZOV}{if $login_user}<br>{$row.GRADE}<br>{$row.EQUIP}{/if}</td>
							<td class=form-ta style="padding: 0px 5px 0px 5px;">{$row.COLOR}</td>
							<td class=form-ta style="padding: 0px 5px 0px 5px;">{$row.PRIV}</td>
							<td class=form-ta style="padding: 0px 5px 0px 5px;">{$row.KPP}</td>
							<td class=form-ta align=right style="padding: 0px 5px 0px 5px;">{$row.ENG_V}</td>
							<td class=form-ta align=right style="padding: 0px 5px 0px 5px;">{$row.MILEAGE}</td>
							<td class=form-ta align=right style="padding: 0px 5px 0px 5px;">{$row.RATE}</td>
							<td class=form-ta nowrap align=right style="padding: 0px 5px 0px 5px;">{$row.START} ¥{if $direct_user}<br>{$row.FINISH} ¥<br><FONT COLOR="#9999ff">{$row.STATUS}</FONT>{/if}</td>
					</tr>
					{/foreach}
			</table>
		{/if}
	{/if}
{/if}

</div>
</div>
</div>