{if $cked==1}<script type = "text/javascript" src = "./jscripts/ckeditor/ckeditor.js"></script>{/if}
<form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method=post ENCTYPE="multipart/form-data">
	<table border=0 align=left cellpadding=1 cellspacing=1 style="margin:0px 0px 0px 10px;">
		<input type=hidden name=save value=yes>
		{if $content_list}
			{if $sub_content1==0 && $sub_content2==1}
				{foreach item = row from = $content_list key=i}
					{if $row.type!=3}
						{if $row.type==2}
							<tr bgColor=#e0e0e0>
								<p style="margin:1px 10px 1px 10px;">[{$row.id}]&nbsp;{$row.name}</p>
								<td>
									{if $row.value}
										<img src="./pics/content/{$row.value}" {if $row.pic_xy.0>300}width=300{/if} border=0 style="margin:3px 10px 0px 10px;">
										<p style="margin:0px 10px 3px 10px;">{$row.value} ({$row.pic_size}) - {$row.pic_xy.0}x{$row.pic_xy.1}</p>
									{/if}
								</td>
								<td>
									<input type=file name=v{$row.id}>
								</td>
							</tr>
						{else}
							<tr bgColor=#e0e0e0>
								<td colspan=2>
									<p style="margin:1px 10px 3px 0px;">[{$row.id}]&nbsp;{$row.name}</p>
									<textarea id="editor1" name=v{$row.id} style="margin:1px 10px 1px 0px;border:1px solid #000000;width:1000px;height:500px;">{$row.value}</textarea>
									{if $cked==1}
									{if $row.content_id!=308}
										<script>
										{literal}
											CKEDITOR.replace( 'editor1', {
												width:	 1000, height:  500,
												toolbar: [
													[ 'Source' ],
													[ 'Undo', 'Redo' ],
													[ 'NewPage', '-', 'Preview', '-', 'Templates' ],
													[ 'Cut', 'Copy', 'Paste', '-', 'PasteText', 'PasteFromWord' ],
													[ 'Find', 'Replace', '-', 'SelectAll' ],
													[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
													'/', 
													[ 'Styles', 'Format', 'Font', 'FontSize' ],
													[ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ],
													[ 'Anchor', 'Link', 'Unlink', 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ],
													[ 'TextColor', 'BGColor' ],
													[ 'Maximize', 'ShowBlocks' ]
												],
												enterMode: CKEDITOR.ENTER_BR,
												shiftEnterMode: CKEDITOR.ENTER_P,
												allowedContent: true,
												removePlugins: 'elementspath', 
												removePlugins: 'about,save',
											});
											CKEDITOR.on('instanceReady', function (ev) { 
											   ev.editor.document.on('drop', function (ev) {ev.data.preventDefault(true);});
											});							
										{/literal}
										</script>
									{/if}
									{/if}
								</td>
							</tr>
						{/if}
					{/if}
				{/foreach}
			{else}
				{foreach item = row from = $content_list key=i}
					{if $row.type!=3}
						{if $row.type==2}
							<tr bgColor=#e0e0e0>
								<td>
									<p style="margin:1px 10px 1px 10px;">[{$row.id}]&nbsp;{$row.name}</p>
									{if $row.value}
										<img src="./pics/content/{$row.value}" {if $row.pic_xy.0>300}width=300{/if} border=0 style="margin:3px 10px 0px 10px;">
										<p style="margin:0px 10px 3px 10px;">{$row.value} ({$row.pic_size}) - {$row.pic_xy.0}x{$row.pic_xy.1}</p>
									{/if}
								</td>
								<td>
									<input type=file name=v{$row.id}>
								</td>
							</tr>
						{else}
							{if $row.type==1}
								<tr bgColor=#e0e0e0>
									<td colspan=2>
										<p style="margin:1px 10px 1px 10px;">[{$row.id}]&nbsp;{$row.name}</p>
										<textarea id="editor{$i+1}" name=v{$row.id} style="margin:1px 10px 1px 0px;border:1px solid #000000;width:1000px;height:300px;">{$row.value}</textarea>
										{if $cked==1}
										{if $row.content_id!=308}
											<script>
											{literal}
												CKEDITOR.replace( 'editor{/literal}{$i+1}{literal}', {
													width:	 1000, height:  300,
													toolbar: [ 
														[ 'Source' ],
														[ 'Undo', 'Redo' ],
														[ 'NewPage', '-', 'Preview', '-', 'Templates' ],
														[ 'Cut', 'Copy', 'Paste', '-', 'PasteText', 'PasteFromWord' ],
														[ 'Find', 'Replace', '-', 'SelectAll' ],
														[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
														'/', 
														[ 'Styles', 'Format', 'Font', 'FontSize' ],
														[ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ],
														[ 'Anchor', 'Link', 'Unlink', 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ],
														[ 'TextColor', 'BGColor' ],
														[ 'Maximize', 'ShowBlocks' ]
													],
													enterMode: CKEDITOR.ENTER_BR,
													shiftEnterMode: CKEDITOR.ENTER_P,
													allowedContent: true,
													removePlugins: 'elementspath', 
													removePlugins: 'about,save',
												});
												CKEDITOR.on('instanceReady', function (ev) { 
												   ev.editor.document.on('drop', function (ev) {ev.data.preventDefault(true);});
												});							
											{/literal}
											</script>
										{/if}
										{/if}
									</td>
								</tr>
							{else}
								<tr bgColor=#e0e0e0>
									<td><p style="margin:1px 10px 1px 10px;">[{$row.id}]&nbsp;{$row.name}</p></td>
									<td>
										<input name=v{$row.id} value="{$row.value}" style="margin:1px 10px 1px 0px;border:1px solid #000000;width:600px;">
									</td>
									{if $id==8}
										<td>
											<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&del={$row.id}" onClick="return confirm('Вы точно хотите удалить &#171;{$row.name}&#187;?');"><img src="./pics/del.gif" width=9 height=10 border=0></a>&nbsp;
										</td>
									{/if}
								</tr>
							{/if}
						{/if}
					{/if}
				{/foreach}
			{/if}
		{/if}
		<tr>
			<td colspan=2 align=center>
				<input type=image src="./pics/admin-save.gif" width=107 height=20 style="margin:10px 10px 0px 0px;">
				{if $id==8}<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&add"><img src="./pics/admin-add.gif" width=107 height=20 border=0></a>{/if}
			</td>
		</tr>
		{if $id==8}
			<tr>
				<td></td>
				<td style="padding-top:10px;">Добавление и удаление услуги происходит одновременно на всех языках!</td>
			</tr>
		{/if}
		<tr height=20><td></td><td></td></tr>
	</table>
</form>
