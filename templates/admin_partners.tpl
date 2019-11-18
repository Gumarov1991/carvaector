{if $edit}
<table cellspacing=0 cellpadding=0 style="margin:0px 20px 0px 20px;">
        <tr>
                <td>
                        <table cellspacing=0 cellpadding=0 style="margin:30px 20px 0px 20px;">
                                <form action="./admin.php?partners&edit={$edit}" method=post>
                                <input type=hidden name=save value=yes>
                                <tr><td>Поддомен:</td></tr>
                                <tr><td><input name=subd value="{$edit}" style="border:1px solid #008000;width:600px;margin:2px 0px 10px 0px;"></td></tr>
                                <tr><td>Наименование партнера:</td></tr>
                                <tr><td><input name=name value="{$name}" style="border:1px solid #008000;width:600px;margin:2px 0px 10px 0px;"></td></tr>
                                <tr><td>Содержание страницы:</td></tr>
                                <tr><td><textarea id=msg_id name=note style="border:1px solid #008000;width:600px;height:300px;margin:2px 0px 10px 0px;">{$note}</textarea></td></tr>
                                <tr>
                                        <td>
                                                <input type=image src="./pics/admin-save.gif" width=107 height=20>
                                                <a href="./admin.php?partners"><img src="./pics/admin-cancel.gif" width=107 height=20 border=0></a>
                                        </td>
                                </tr>
                                </form>
                        </table>
                </td>
                <td valign=top style="padding:40px 10px 10px 10px;">{include file="admin_content_files.tpl"}</td>
        </tr>
</table>
{else}
<table cellspacing=0 cellpadding=0 style="margin:30px 20px 0px 20px;">
        <form action="./admin.php?partners" method=post>
        <input type=hidden name=add value=yes>
        <tr>
                <td>Поддомен:</td>
                <td><input name=subd style="border:1px solid #008000;width:200px;margin:0px 30px 0px 5px;"></td>
                <td>Наименование партнера:</td>
                <td><input name=name style="border:1px solid #008000;width:200px;margin:0px 10px 0px 5px;"></td>
                <td><input type=image src="./pics/admin-add.gif" width=107 height=20></td>
        </tr>
        </form>
</table>
<table cellspacing=1 cellpadding=0 width=935 style="margin:5px 20px 50px 20px;" bgColor=#000000>
        <tr>
                <td class=form-ha></td>
                <td class=form-ha><b>Сайт</b></td>
                <td class=form-ha><b>Наименование</b></td>
        </tr>
        {foreach item = row from = $partners}
        <tr>
                <td class=form-ta>
                        <a href="./admin.php?partners&del={$row.subd}" onClick="return confirm('Вы уверены, что хотите удалить сайт {$row.site}');"><img src="./pics/del.gif" border=0 width=9 height=10 alt="Удалить" title="Удалить"></a>
                        <a href="./admin.php?partners&edit={$row.subd}"><img src="./pics/edit.gif" border=0 width=9 height=10 alt="Редактировать" title="Редактировать"></a>
                </td>
                <td class=form-ta><a href="https://{$row.site}" target=_blank>{$row.site}</a></td>
                <td class=form-ta>{$row.name}</td>
        </tr>
        {/foreach}
</table>
</form>
{/if}
