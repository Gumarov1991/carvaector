<form action="./admin.php?content&lang_id={$lang_id}&id={$id}" method=post>
<input type=hidden name=save value="yes">
<input type=image src="./pics/admin-save.gif" width=107 height=20 style="margin:0px 10px 10px 10px;">
<a href="./admin.php?content&lang_id={$lang_id}&id={$id}&add_dostavka_row"><img src="./pics/admin-add.gif" width=107 height=20 border=0 style="margin:0px 10px 10px 10px;"></a>
<table cellpadding=1 cellspacing=1 style="margin:0px 10px 30px 10px;" bgColor=#000000>
        <tr>
                <td bgColor=#99FF66></td>
                <td bgColor=#99FF66>Страна-экспортер</td>
                <td bgColor=#99FF66>Страна-импортер</td>
                <td bgColor=#99FF66>Пункт назначения</td>
                <td colspan=2 bgColor=#99FF66>Налоги, сборы, оформление документов и прочие накладные расходы</td>
                <td colspan=2 bgColor=#99FF66>Комиссия компании CarVector</td>
                <td colspan=2 bgColor=#99FF66>Услуги транспортных компаний</td>
                <td colspan=2 bgColor=#99FF66>Таможенная пошлина и сопутствующие налоги</td>
                <td colspan=2 bgColor=#99FF66>Терминальная обработка и услуги брокера</td>
        </tr>
        {foreach item = row from = $dostavkas key=i}
        <tr>
                <td bgColor=#99FF66><a href="./admin.php?content&lang_id={$lang_id}&id={$id}&del_dostavka_row={$row.id}" onClick="return confirm('Вы уверены, что хотите удалить строку {$i+1}?');"><img src="./pics/del.gif" border=0></a>&nbsp;&nbsp;{$i+1}</td>
                <td width=100 bgColor=#ffffff><input name=exp{$row.id} value="{$row.exp}" style="border:0px;width:100%;"></td>
                <td width=100 bgColor=#ffffff><input name=imp{$row.id} value="{$row.imp}" style="border:0px;width:100%;"></td>
                <td width=100 bgColor=#ffffff><input name=dest{$row.id} value="{$row.dest}" style="border:0px;width:100%;"></td>
                <td width=40 bgColor=#ffffff><input name=summa1_{$row.id} value="{$row.summa1}" style="border:0px;width:100%;"></td>
                <td bgColor=#ffffff><input name=descr1_{$row.id} value="{$row.descr1}" style="border:0px;width:100%;"></td>
                <td width=40 bgColor=#ffffff><input name=summa2_{$row.id} value="{$row.summa2}" style="border:0px;width:100%;"></td>
                <td bgColor=#ffffff><input name=descr2_{$row.id} value="{$row.descr2}" style="border:0px;width:100%;"></td>
                <td width=40 bgColor=#ffffff><input name=summa3_{$row.id} value="{$row.summa3}" style="border:0px;width:100%;"></td>
                <td bgColor=#ffffff><input name=descr3_{$row.id} value="{$row.descr3}" style="border:0px;width:100%;"></td>
                <td width=40 bgColor=#ffffff><input name=summa4_{$row.id} value="{$row.summa4}" style="border:0px;width:100%;"></td>
                <td bgColor=#ffffff><input name=descr4_{$row.id} value="{$row.descr4}" style="border:0px;width:100%;"></td>
                <td width=40 bgColor=#ffffff><input name=summa5_{$row.id} value="{$row.summa5}" style="border:0px;width:100%;"></td>
                <td bgColor=#ffffff><input name=descr5_{$row.id} value="{$row.descr5}" style="border:0px;width:100%;"></td>
        </tr>
        {/foreach}
</table>
</form>
