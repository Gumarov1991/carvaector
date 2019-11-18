<table cellpadding=0 cellspacing=0 style="margin:0px 10px 5px 10px;">
        <tr>
                <td colspan=2><a href="http://www.maxmind.com/app/geolitecity" target=_blank>Ссылка для скачивания таблицы IP адресов (обновляется раз в месяц, скачивать CSV формат)</a></td>
        </tr>
        <tr height=10><td></td></tr>
        <tr>
                <td colspan=2>
                        <p>Загрузить файл таблицы на сервер (может занять несколько минут, необходимо дождаться до завершения)</p>
                </td>
        </tr>
        <form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method=post ENCTYPE="multipart/form-data">
        <tr>
                <td>
                        <input type=file name=fn style="margin:0px 0px 5px 0px;">&nbsp;
                        <input type=image src="./pics/admin-add.gif" width=107 height=20>
                </td>
                </form>
                <form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method=post>
                <input type=hidden name=save value=yes>
                <td align=right>
                        <input type=image src="./pics/admin-save.gif" width=107 height=20>
                </td>
        </tr>
</table>
<table cellpadding=0 cellspacing=0 style="margin:0px 10px 5px 10px;">
        {foreach item = row from = $iptables key=i}
        {if fmod($i,3)==0}<tr height=1 bgColor=#008000><td colspan=8></td></tr><tr>{/if}
                <td style="padding-left:10px;">{$row.country}</td>
                <td>
                        <select size=1 name=lang{$row.short} style="margin:1px 10px 1px 10px;">
                        {foreach item = rows from = $languages}
                        <option value="{$rows.id}"{if $row.language_id==$rows.id} selected{/if}>{$rows.name}</option>
                        {/foreach}
                        </select>
                </td>
        {if fmod($i,3)==2}</tr>{else}<td width=1 bgColor=#008000></td>{/if}
        {/foreach}
        </form>
</table>
