{if !$edit}
	<p style="margin:10px;"><a href="./admin.php?content&lang_id={$lang_id}&id=faq&edit=add" style="color:#449944;">добавить вопрос-ответ</a></p>
	<table cellpadding=0 cellspacing=1 bgColor=#ccffcc style="margin:0px 10px 30px 10px;">
		{foreach item = row from = $faq_list key=i}
			<tr>
				<td bgColor=#ffffff><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&up={$row.id}"><img src="./pics/up.gif" border=0 width=9 height=10></a></td>
				<td bgColor=#ffffff><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&down={$row.id}"><img src="./pics/down.gif" border=0 width=9 height=10></a></td>
				<td bgColor=#ffffff style="padding:0px 10px 0px 10px;">
					<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$row.id}" style="color:#{if $row.confirm}999999{else}000000{/if};font-size:14px;{if $edit==$row.id}text-decoration:underline;{/if}">
						{$row.quest}
					</a>
				</td>
				<td bgColor=#ffffff><a href="./admin.php?content&lang_id={$lang_id}&id=faq&del={$row.id}" onClick="return confirm('Вы хотите удалить вопрос &#171;{$row.quest}&#187;?');"><img src="./pics/del.gif" border=0 width=9 height=10></a></td>
			</tr>
		{/foreach}
	</table>
{else}
{if $cked==1}<script type = "text/javascript" src = "./jscripts/ckeditor/ckeditor.js"></script>{/if}
<form action="./admin.php?content&lang_id={$lang_id}&id={$id}&edit={$edit}" method=post>
	<table cellpadding=0 cellspacing=0 style="margin:0px 10px 30px 10px;">
        <input type=hidden name=save value=yes>
        <tr>
			<td>Вопрос: </td>
			<td><textarea name=quest rows=1 style="width:600px">{$r.quest}</textarea></td>
        </tr>
        <tr>
			<td>Ответ: </td>
			<td>
				<textarea id="editor1" name=answer style="width:600px;height:500px;">{$r.answer}</textarea>
				{if $cked==1}
					<script>
					{literal}
						CKEDITOR.replace( 'editor1', {
							width:	 600, height:  500,
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
							removePlugins: 'elementspath', 
							removePlugins: 'about,save',
						});
						CKEDITOR.on('instanceReady', function (ev) { 
						   ev.editor.document.on('drop', function (ev) {ev.data.preventDefault(true);});
						});							
					{/literal}
					</script>
				{/if}
			</td>
        </tr>
        <tr>
			<td></td>
			<td style="padding-top:5px;"><input type=image src="./pics/admin-save.gif" width=107 height=20></td>
        </tr>
	</table>
</form>
{/if}
