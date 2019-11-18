<div class="container min-h-500">
	<div class="row">
		<div clas="col-xl-12 col-lg-12">
<p style="font-size:14px;margin:10px 10px 0px 100px;">
	<span class=nav>{$content_5}</span>
</p>
<script type="text/javascript">
	var exp_p = new Array();
	var imp_p = new Array();
	var dest_p = new Array();
	var s1 = new Array();
	var d1 = new Array();
	var s2 = new Array();
	var d2 = new Array();
	var s3 = new Array();
	var d3 = new Array();
	var s4 = new Array();
	var d4 = new Array();
	var s5 = new Array();
	var d5 = new Array();
	{foreach item = row from = $dostavka key=i}
		exp_p[{$i}] = '{$row.exp}';
		imp_p[{$i}] = '{$row.imp}';
		dest_p[{$i}] = '{$row.dest}';
		s1[{$i}] = '{$row.summa1}';
		d1[{$i}] = '{$row.descr1}';
		s2[{$i}] = '{$row.summa2}';
		d2[{$i}] = '{$row.descr2}';
		s3[{$i}] = '{$row.summa3}';
		d3[{$i}] = '{$row.descr3}';
		s4[{$i}] = '{$row.summa4}';
		d4[{$i}] = '{$row.descr4}';
		s5[{$i}] = '{$row.summa5}';
		d5[{$i}] = '{$row.descr5}';
	{/foreach}
</script>
<form method="post" action="./index.php?calc{if $back}&back=yes{/if}" onSubmit="return false;">
	<input type=hidden name=search value=yes>
	<table cellspacing=0 cellpadding=0 width=803 style="margin:40px 86px 30px 86px;">
		<tr><td><img src="./pics/calc-fon1.gif" widht=803 height=13 border=0></td></tr>
		<tr>
			<td width=803 background="./pics/calc-fon2.gif" valign=top style="padding-left:3px;padding-right:3px;">
				<table cellspacing=0 cellpadding=0 width=100%>
					<tr height=51>
						<td colspan=3>
							<table cellspacing=0 cellpadding=0 width=100% style="margin-left:15px;">
								<tr>
									<td class=form-s>{$content_225}</td>
									<td>
										<span id=exp_span>
											<select size=1 style="width:147px;" name=exp onChange="change_calc(this,{if $back}0{else}1{/if});">
												{foreach item = row from = $exp}
													<option{if $row.exp==$d.exp} selected{/if}>{$row.exp}</option>
												{/foreach}
											</select>
										</span>
									</td>
									<td class=form-s>{$content_226}</td>
									<td>
										<span id=imp_span>
											<select size=1 style="width:147px;" name=imp onChange="change_calc(this,{if $back}0{else}1{/if});">
												{foreach item = row from = $imp}
													<option{if $row.imp==$d.imp} selected{/if}>{$row.imp}</option>
												{/foreach}
											</select>
										</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					{if $back}
						<tr bgColor=#ccff66>
							<td class=calc-b align=right>{$content_239}</td>
							<td class=calc-i><input name=total onKeyUp="change_calc(this,0);" value="{$d.summa1+$d.summa2+$d.summa3+$d.summa4+$d.summa5}" class=calc-i></td>
							<td></td>
						</tr>
						<tr><td class=calc-b colspan=3>{$content_235}</td></tr>
						<tr bgColor=#ccff66>
							<td class=calc-n>{$content_237}</td>
							<td class=calc-i><p id=p5 class=calc-i>{$d.summa5}</p></td>
							<td class=calc-nn><span id=pp5>{$d.descr5}</span></td>
						</tr>
						<tr>
							<td class=calc-n>{$content_236}</td>
							<td class=calc-i><p id=p4 class=calc-i>{$d.summa4}</p></td>
							<td class=calc-nn><span id=pp4>{$d.descr4}</span></td>
						</tr>
						<tr bgColor=#ccff66>
							<td colspan=3>
								<table cellspacing=0 cellpadding=0>
									<tr>
										<td class=calc-b>{$content_232}</td>
										<td class=calc-i>&nbsp;
											<span id=dest_span>
												<select size=1 style="width:147px;" name=dest onChange="change_calc(this,0);">
													{foreach item = row from = $dest}
														<option{if $row.dest==$d.dest} selected{/if}>{$row.dest}</option>
													{/foreach}
												</select>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td class=calc-n>{$content_234}</td>
							<td class=calc-i><p id=p3 class=calc-i>{$d.summa3}</p></td>
							<td class=calc-nn><span id=pp3>{$d.descr3}</span></td>
						</tr>
						<tr bgColor=#ccff66><td class=calc-b colspan=3>{$content_230}</td></tr>
						<tr>
							<td class=calc-n>{$content_231}</td>
							<td class=calc-i><p id=p2 class=calc-i>{$d.summa2}</p></td>
							<td class=calc-nn><span id=pp2>{$d.descr2}</span></td>
						</tr>
						<tr bgColor=#ccff66><td class=calc-b colspan=3>{$content_227}</td></tr>
						<tr>
							<td class=calc-n>{$content_229}</td>
							<td class=calc-i><p id=p1 class=calc-i>{$d.summa1}</p></td>
							<td class=calc-nn><span id=pp1>{$d.descr1}</span></td>
						</tr>
						<tr bgColor=#ccff66><td class=calc-b colspan=3>--------------------------------------------------------------------------------------------------------------------------------</td></tr>
						<tr>
							<td class=calc-b>{$content_228}</td>
							<td class=calc-i><p id=sum class=calc-i>0</p></td>
							<td></td>
						</tr>
						<tr>
							<td colspan=3 style="padding-top:20px;padding-left:20px;">
									<a href="./index.php?calc"><img src="./pics/content/{$content_325}" width="{$content_xy_325.0}" height="{$content_xy_325.1}" border=0></a>
							</td>
						</tr>
					{else}
						<tr bgColor=#ccff66>
							<td class=calc-b>{$content_228}</td>
							<td class=calc-i><input name=sum value="0" class=calc-i onKeyUp="change_calc(this,1);"></td>
							<td></td>
						</tr>
						<tr><td class=calc-b colspan=3>{$content_227}</td></tr>
						<tr bgColor=#ccff66>
							<td class=calc-n>{$content_229}</td>
							<td class=calc-i><p id=p1 class=calc-i>{$d.summa1}</p></td>
							<td class=calc-nn><span id=pp1>{$d.descr1}</span></td>
						</tr>
						<tr><td class=calc-b colspan=3>{$content_230}</td></tr>
						<tr bgColor=#ccff66>
							<td class=calc-n>{$content_231}</td>
							<td class=calc-i><p id=p2 class=calc-i>{$d.summa2}</p></td>
							<td class=calc-nn><span id=pp2>{$d.descr2}</span></td>
						</tr>
						<tr>
							<td colspan=3>
								<table cellspacing=0 cellpadding=0>
									<tr>
										<td class=calc-b>{$content_232}</td>
										<td class=calc-i>&nbsp;
											<span id=dest_span>
												<select size=1 style="width:147px;" name=dest onChange="change_calc(this,1);">
													{foreach item = row from = $dest}
														<option{if $row.dest==$d.dest} selected{/if}>{$row.dest}</option>
													{/foreach}
												</select>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr bgColor=#ccff66>
							<td class=calc-n>{$content_234}</td>
							<td class=calc-i><p id=p3 class=calc-i>{$d.summa3}</p></td>
							<td class=calc-nn><span id=pp3>{$d.descr3}</span></td>
						</tr>
						<tr><td class=calc-b colspan=3>{$content_235}</td></tr>
						<tr bgColor=#ccff66>
							<td class=calc-n>{$content_236}</td>
							<td class=calc-i><p id=p4 class=calc-i>{$d.summa4}</p></td>
							<td class=calc-nn><span id=pp4>{$d.descr4}</span></td>
						</tr>
						<tr>
							<td class=calc-n>{$content_237}</td>
							<td class=calc-i><p id=p5 class=calc-i>{$d.summa5}</p></td>
							<td class=calc-nn><span id=pp5>{$d.descr5}</span></td>
						</tr>
						<tr bgColor=#ccff66><td class=calc-b colspan=3>--------------------------------------------------------------------------------------------------------------------------------</td></tr>
						<tr>
							<td class=calc-b align=right>{$content_238}</td>
							<td class=calc-i><p id=total class=calc-i>{$d.summa1+$d.summa2+$d.summa3+$d.summa4+$d.summa5}</p></td>
							<td></td>
						</tr>
						<tr>
							<td colspan=3 style="padding-top:20px;padding-left:20px;">
									<a href="./index.php?calc&back=yes"><img src="./pics/content/{$content_324}" width="{$content_xy_324.0}" height="{$content_xy_324.1}" border=0></a>
							</td>
						</tr>
					{/if}
				</table>
			</td>
		</tr>
		<tr><td><img src="./pics/calc-fon3.gif" widht=803 height=12 border=0></td></tr>
	</table>
</form>
<p style="margin-left: 20px;">{$content_240}</p>

</div>
</div>
</div>
