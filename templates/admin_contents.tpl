<table cellpadding=0 cellspacing=0 style="margin:20px 0px 0px 0px;">
        <tr>
                <td valign=top nowrap>
                        {include file="admin_content_menu.tpl" res=$contents beg="yes" admin_contents="yes"}
                </td>
                <td width=1 bgColor=#000000 nowrap></td>
                <td valign=top width=100%>
                        {if $content_list}
                        <table cellpadding=0 cellspacing=0 style="margin:0px 0px 0px 10px;">
                                <form action="./admin.php?contents&id={$id}" method=post>
                                <input type=hidden name=save value=yes>
                                {foreach item = row from = $content_list key=i}
                                <tr bgColor=#{if fmod($i,2)==0}ffffff{else}e0e0e0{/if}>
                                        <td style="padding:0px 10px 0px 10px;">{$row.id}</td>
                                        <td>
                                                <input name=p{$row.id} value="{$row.position}" style="margin:1px 10px 1px 0px;border:1px solid #000000;width:40px;">
                                        </td>
                                        <td>
                                                <input name=n{$row.id} value="{$row.name}" style="margin:1px 10px 1px 0px;border:1px solid #000000;width:300px;">
                                        </td>
                                        <td>
                                                <select name=t{$row.id} size=1 style="margin:1px 10px 1px 0px;border:1px solid #000000;width:100px;">
                                                <option value="0"{if $row.type==0} selected{/if}>Text</option>
                                                <option value="1"{if $row.type==1} selected{/if}>TextArea</option>
                                                <option value="2"{if $row.type==2} selected{/if}>Img</option>
                                                <option value="3"{if $row.type==3} selected{/if}>Невидимый</option>
                                                </select>
                                        </td>
                                        <td>
                                                <a href="./admin.php?contents&id={$id}&del={$row.id}" onClick="return confirm('Вы уверены, что хотите удалить контент &#171;{$row.name}&#187;');"><img src="./pics/del.gif" border=0 width=9 height=10 alt="Удалить" title="Удалить"></a>
                                        </td>
                                </tr>
                                {/foreach}
                                <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                                <input type=image src="./pics/admin-save.gif" width=107 height=20 style="margin:20px 10px 20px 10px;">
                                                <a href="./admin.php?contents&id={$id}&add"><img src="./pics/admin-add.gif" width=107 height=20 border=0 style="margin:20px 10px 20px 10px;"></a>
                                        </td>
                                </tr>
                                </form>
                        </table>
                        {else}
                        <a href="./admin.php?contents&id={$id}&add"><img src="./pics/admin-add.gif" width=107 height=20 border=0 style="margin:20px 10px 20px 10px;"></a>
                        {/if}
                </td>
        </tr>
</table>
