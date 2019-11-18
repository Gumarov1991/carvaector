<table cellspacing=0 cellpadding=0 style="margin:30px 0px 0px 0px;" width=700>
        <form method="post" action="./admin.php?languages">
        <input type=hidden name=save value=yes>
        <tr>
                <td class=form-h1>&nbsp;</td>
                <td class=form-h1><b>Язык</b></td>
                <td class=form-h1><b>Активность</b></td>
                <td class=form-h1>&nbsp;</td>
        </tr>
        {foreach item = row from = $languages}
        <tr>
                <td class=form-h2>
                        <a href="./admin.php?languages&del={$row.id}" onClick="return confirm('Вы уверены, что хотите удалить язык &#171;{$row.name}&#187;. При его удалении будет утерян весь его контент.');"><img src="./pics/del.gif" border=0 width=9 height=10 alt="Удалить язык" title="Удалить язык"></a>
                </td>
                <td class=form-h2><input name=name{$row.id} style="margin:0px;width:300px;" value="{$row.name}"></td>
                <td class=form-h2><input type=checkbox name=active{$row.id} value="yes"{if $row.active} checked{/if}></td>
                <td class=form-h2><a href="./index.php?language={$row.id}" target=_blank>Просмотреть сайт на этом языке</a></td>
        </tr>
        {/foreach}
        <tr>
                <td></td>
                <td>
                        <input type=image src="./pics/admin-save.gif" width=107 height=20 style="margin:20px 10px 20px 10px;">
                        <a href="./admin.php?languages&add"><img src="./pics/admin-add.gif" width=107 height=20 border=0 style="margin:20px 10px 20px 10px;"></a>
                </td>
                <td></td>
                <td></td>
        </tr>
        </form>
</table>
