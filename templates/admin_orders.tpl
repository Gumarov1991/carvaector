{if $id}

	<p align="left" style="margin:5px 10px 0px 10px;">Order of: <b>{$uname}</b></p>
	<HR>
	<table border=0 align="left" cellspacing=0 cellpadding=0 style="margin:10px 10px 0px 10px;">
		<tr>
			<td rowspan=2 valign="top">
				<form method="post" action="./admin.php?orders&page={$page}&id={$id}&finduid={$finduid}&findtrno={$findtrno}">
					<input type=hidden name=save value=yes>
					<table cellspacing=0 cellpadding=0>
						<tr>
							<td class=adm-us nowrap>TrNo</td>
							<td><input name=trno value="{$order.trno}" class=adm-us style="width:400px;"{if !$grant.2} readonly{/if}></td>
						</tr>
						<tr>
							<td class=adm-us nowrap>Date</td>
							<td><input name=adate value="{$order.adate}" class=adm-us style="width:400px;"{if !$grant.2} readonly{/if}></td>
						</tr>
						<tr>
							<td class=adm-us nowrap>Description of Goods</td>
							<td><input name=name value="{$order.name}" class=adm-us style="width:400px;"{if !$grant.2} readonly{/if}></td>
						</tr>
						<tr>
							<td class=adm-us nowrap>Destination</td>
							<td><input name=alocation value="{$order.alocation}" class=adm-us style="width:400px;"{if !$grant.2} readonly{/if}></td>
						</tr>
						<tr>
							<td class=adm-us nowrap valign="top">Logistics</td>
							<td><textarea name=logist class=adm-us rows=4 style="width:400px;"{if !$grant.2} readonly{/if}>{$order.logist}</textarea></td>
						</tr>
						<tr><td style="height:15px"></td></tr>
						<tr>
							<td class=adm-us nowrap valign="top" style="color:#888">Manager Note<br>(Not shown to the Client)</td>
							<td><textarea name=note class=adm-us rows=4 style="width:400px;"{if !$grant.2} readonly{/if}>{$order.note}</textarea></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<a href="./admin.php?orders&page={$page}&finduid={$finduid}&findtrno={$findtrno}"><img src="./pics/admin-cancel.gif" width=107 height=20 border=0 style="margin:10px 10px 0px 10px;"></a>
								{if $grant.2}<input type=image src="./pics/admin-save.gif" width=107 height=20 style="margin:10px 10px 0px 10px;">{/if}
							</td>
						</tr>
					</table>
				</form>
				<div align="left" style="margin-left:10px; width:550px;"><br>
					In the Private Page the Client can't see:<br>
					<span style="color:#888"><b>Manager's Note</b></span>, <span style="color:#888"><b>size of files</b></span> and <span style="color:#888"><b>size of pictures</b></span> (it is marked <span style="color:#888"><b>grey color</b></span>)
				</div>
				{if $grant.2}
					<div align="left" style="margin-left:10px; width:550px;">
						It is possible to load any files to the customer order, for example graphical (jpg, gif, png) or text (txt, doc, pdf) and others.<br>
						Notice the client can't see a name of the loaded file. If to load graphical files like <b>jpg</b>, <b>gif</b>, <b>png</b> the miniature will show their reduced image. In this case a file can be loaded without name. The corresponding miniatures will be appropriated to other files like <b>txt</b>, <b>doc</b>, <b>pdf</b>, but in this case miniatures don't show content of the files. therefore before loading it is necessary to enter names for not graphical files. Otherwise the client will see such files without name, and he should open each file to see its content.
					</div>
				{/if}
			<td nowrap height=2">
				{if $grant.2}
					<form method="post" action="./admin.php?orders&page={$page}&id={$id}&findtrno={$findtrno}&finduid={$finduid}" ENCTYPE="multipart/form-data">
						<input name=note class=adm-us style="margin:6px 0px 4px 10px;width:130px;" title="Name of loading file (for the Client)">
						<input type=file name=fn style="margin:6px 10px 4px 0px;">
						<input type=submit name=add value="Add file" style="margin:6px 10px 4px 0px;">
					</form>
				{/if}
			</td>
		</tr>
		<tr>
			<td valign=top>
				<table border=0 FRAME=BOX RULES=ALL cellpadding=0 cellspacing=0 style="margin:0px 0px 20px 10px;" bgColor=#ffffff>
					{foreach item = row from = $pics key=i}
						{if fmod($i,3)==0}<tr>{/if}
							<td nowrap bgColor=#ffffff valign=top>
								{if $row.href}
									{if $grant.2}
										<p style="margin:3px;">
											<a href="./admin.php?orders&page={$page}&id={$id}&findtrno={$findtrno}&finduid={$finduid}&del={$row.url}" onClick="return confirm('Delete file {$row.name} ?');">
												<img src="./pics/del.gif" width=9 height=10 border=0>
											<a>
										</p>
									{/if}
									<a href="{$row.href}" target=_blank>
										<img src="{if $row.ext!="pic"}{$row.ext}{else}./get_image.php?pic={$row.url}&w=100&h={$row.xy.1*100/$row.xy.0}{/if}"{if $row.ext=="pic"} width="100" height="{$row.xy.1*100/$row.xy.0}"{/if} border=0 style="margin:3px 10px 0px 10px;">
									</a>
									<p style="margin:0px 10px 3px 10px;font-size:10px;">
										<a href="{$row.href}" target=_blank style="font-size:10px;color:#000000;">
											{$row.name}<br><span style="color:#888;">file: {$row.size} byte{if $row.ext=="pic"}<br>pic: {$row.xy.0}x{$row.xy.1}{/if}</span>
										</a>
									</p>
								{/if}
							</td>
						{if fmod($i,3)==2}</tr>{/if}
					{/foreach}
				</table>
			</td>
		</tr>
	</table>

{else}

	<table border=0 width=100% bgColor=#DDFFAA cellspacing=0 cellpadding=0 style="margin:5px 0px 0px 0px;">
		<tr>
			<td nowrap class=ad-cl>&nbsp;&nbsp;<b>Find:</b>&nbsp;&nbsp;&nbsp;</a></td>
			<td nowrap style="padding-left:20px;"><b>TrNo:</b> <input value="{$findtrno}" style="margin:2px 0px;width:100px;" id=findtrno onKeyDown="var key;if (window.event) key = event.keyCode; else if (event.which) key = event.which;if (key==13) window.location = './admin.php?orders&findtrno='+this.value+'&finduid='+document.getElementById('finduid').value;"></td>
			<td nowrap style="padding-left:20px;"><b>Client SiteID:</b> <input value="{$finduid}" style="width:100px;" id=finduid onKeyDown="var key;if (window.event) key = event.keyCode; else if (event.which) key = event.which;if (key==13) window.location = './admin.php?orders&finduid='+this.value+'&findtrno='+document.getElementById('findtrno').value;"></td>
			<td nowrap align=left width=100% style="padding-left:20px;">
			</td>
			{if $finduid and !$findtrno && $grant.2}
				<td align=right style="padding-right:10px">
					<a href="./admin.php?orders&id={$finduid}&add&finduid={$finduid}&findtrno={$findtrno}"><img src="./pics/admin-add.gif" border=0 title="Add Order"></a>
				</td>
			{/if}
		</tr>
	</table>
	<table cellspacing=0 cellpadding=0 width=100% style="margin:2px 0px 5px 0px;">
		<tr>
			<td>
				<p style="margin-left:10px;" align=left>
					{if $page_beg>1}<a href="./admin.php?orders&finduid={$finduid}&findtrno={$findtrno}&page={if ($page-10) > 0}{$page-10}{else}1{/if}" style="font-size:14px;color:#000000;font-weight:normal;">Prev Page</a>&nbsp;&nbsp;<<{/if}
					{foreach item = row from = $pages}
						&nbsp;&nbsp;<a href="./admin.php?orders&finduid={$finduid}&findtrno={$findtrno}&page={$row.n}" class=page{if $row.n==$page}-sel{/if}>{$row.p}</a>
					{/foreach}
					{if $page_beg+9<$page_c}&nbsp;&nbsp;>>&nbsp;&nbsp;<a href="./admin.php?orders&finduid={$finduid}&findtrno={$findtrno}&page={if ($page+10) <= $page_c}{$page+10}{else}{$page_c}{/if}" style="font-size:14px;color:#000000;font-weight:normal;">Next Page</a>{/if}
				</p>
			</td>
		</tr>
	</table>
	<table cellspacing=1 cellpadding=0 width=100% style="margin:0px 0px 0px 0px;" bgColor=#000000>
		<tr>
			<td nowrap class=form-ha><b>SiteID</b></td>
			<td nowrap class=form-ha><b>Name</b></td>
			<td nowrap class=form-ha><b>TrNo</b></td>
			<td nowrap class=form-ha><b>Description of Goods</b></td>
			<td nowrap class=form-ha><b>Destination</b></td>
			<td nowrap class=form-ha><b>Logistics</b></td>
			<td nowrap class=form-ha><b>Manager Note</b></td>
			<td nowrap class=form-ha><b>Action</b></td>
		</tr>
		{foreach item = row from = $orders}
			<tr>
				<td class=form-ta><a href="./admin.php?users&sort=7&sort_str={$row.uid}" style="color:#000000;font-size:14px;font-weight:normal;"><u>{$row.uid}</u></a></td>
				<td class=form-ta>{$row.user_name}</td>
				<td class=form-ta>{$row.trno}</td>
				<td class=form-ta>{$row.name}</td>
				<td class=form-ta>{$row.alocation}</td>
				<td class=form-ta>{$row.logist}</td>
				<td class=form-ta>{$row.note}</td>
				<td class=form-ta nowrap>
					<a href="./admin.php?orders&finduid={$finduid}&findtrno={$findtrno}&page={$page}&id={$row.id}"><img src="./pics/admin-order.gif" width=25 height=21 border=0 title="Edit Order"></a>
					{if $grant.2}<a href="./admin.php?orders&page={$page}&finduid={$finduid}&findtrno={$findtrno}&order_del={$row.id}" onClick="return confirm('Delete the Order of the Client SiteID = {$row.uid} ?');"><img src="./pics/del.gif" width=18 height=20 border=0 title="Delete Order"></a>{/if}
				</td>
			</tr>
		{/foreach}
	</table>
{/if}
