<table cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td nowrap>
			<form action="{if $part=='admin_partners'}./admin.php?partners&edit={$edit}&page={$page}{else}./admin.php?content&lang_id={$lang_id}&id={$id}{if $edit}&edit={$edit}{/if}&page={$page_c}{/if}" method=post ENCTYPE="multipart/form-data">
				<input type=file name=fn style="margin:0px 0px 5px 10px;">&nbsp;
				<input type=image src="./pics/admin-add.gif" width=107 height=20 style="margin:0px 20px 0px 0px;">
			</form>
		</td>
	</tr>
	<tr>
		<td nowrap>
<p style="margin:0px 10px 5px 10px;">
{if $no_pages == 0}
	{if $page_beg>1}<a href="{if $part=='admin_partners'}./admin.php?partners&edit={$edit}&page={$page_beg-1}{else}./admin.php?content&lang_id={$lang_id}&id={$id}{if $edit}&edit={$edit}{/if}&page={$page_beg-1}{/if}" style="font-size:14px;color:#000000;font-weight:normal;">Предыдущая страница</a>&nbsp;&nbsp;<<{/if}
	{foreach item = row from = $pages}
	&nbsp;&nbsp;<a href="{if $part=='admin_partners'}./admin.php?partners&edit={$edit}&page={$row.page}{else}./admin.php?content&lang_id={$lang_id}&id={$id}{if $edit}&edit={$edit}{/if}&page={$row.page}{/if}" class=page{if $row.page==$page}-sel{/if}>{$row.name}</a>
	{/foreach}
	{if $page_beg+9<$page_c}&nbsp;&nbsp;>>&nbsp;&nbsp;<a href="{if $part=='admin_partners'}./admin.php?partners&edit={$edit}&page={$page_beg+10}{else}./admin.php?content&lang_id={$lang_id}&id={$id}{if $edit}&edit={$edit}{/if}&page={$page_beg+10}{/if}" style="font-size:14px;color:#000000;font-weight:normal;">Следующая страница</a>{/if}
{/if}
</p>
		</td>
	</tr>
</table>

<table cellpadding=0 cellspacing=1 style="margin:0px 0px 20px 10px;" bgColor=#008000>
        {foreach item = row from = $pics key=i}
        {if fmod($i,$page_str_n)==0}<tr>{/if}
                <td bgColor=#ffffff valign=top>
                        {if $row.name}
                        <p style="margin:3px;">
                                <a href="{if $part=='admin_partners'}./admin.php?partners&edit={$edit}&page={$page}&del={$row.url}{else}./admin.php?content&lang_id={$lang_id}&id={$id}{if $edit}&edit={$edit}{/if}&page={$page}&del={$row.url}{/if}" onClick="return confirm('Вы уверены, что хотите удалить файл {$row.name}?');"><img src="./pics/del.gif" width=9 height=10 border=0><a>
                                {if $id=="response" or $part=="admin_partners"}&nbsp;&nbsp;&nbsp;<a href="" onClick="
var tv='<img src=\'{if $part=="admin_partners"}./pics/{$row.name}{else}{$row.href}{/if}\' width=\'{$row.xy.0}\' height=\'{$row.xy.1}\' border=\'0\'>';
var t=document.getElementById('msg_id');
t.focus();
{literal}
if (document.selection) {
        var sel = document.selection.createRange();
        var clone = sel.duplicate();
        sel.collapse(true);
        clone.moveToElementText(t);
        clone.setEndPoint('EndToEnd', sel);
        var ts=clone.text.length;
        var te=ts+sel.text.length;
} else {
        var ts=t.selectionStart;
        var te=t.selectionEnd;
}
{/literal}
t.value=t.value.substring(0,ts)+tv+t.value.substring(te);
{literal}
if (document.selection) {
        var start = t.value.substr(0, ts+tv.length).replace('/\r/g', '').length;
        with (t.createTextRange()) {
                collapse();
                moveStart('character', start);
                moveEnd('character', 0);
                select();
        }
} else {
        t.selectionStart = ts+tv.length;
        t.selectionEnd = t.selectionStart;
}
{/literal}
return false;
                                " style="font-size:12px;font-weight:normal;color:#000000;">вставить</a>{/if}
                        </p>
                        <a href="{$row.href}" target=_blank><img src="{if $row.ext!="pic"}{$row.ext}{else}./get_image.php?pic={$row.url}&w=100&h={$row.xy.1*100/$row.xy.0}{/if}"{if $row.ext=="pic"} width="100" height="{$row.xy.1*100/$row.xy.0}"{/if} border=0 style="margin:3px 10px 0px 10px;"></a><p style="margin:0px 10px 3px 10px;font-size:10px;"><a href="{$row.href}" target=_blank style="font-size:10px;color:#000000;">{$row.name}<br>размер файла: {$row.size}{if $row.ext=="pic"}<br>размер картинки: {$row.xy.0}x{$row.xy.1}{/if}</a></p>{/if}
                </td>
        {if fmod($i,$page_str_n)==$page_str_n-1}</tr>{/if}
        {/foreach}
</table>
