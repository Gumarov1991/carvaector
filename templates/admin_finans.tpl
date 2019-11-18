<p style="margin:10px 0px 0px 10px;text-align:left;font-weight:bold;color:#000000;font-size:14px;">Non-Zero results in balances of Clients</p>
<p style="margin:10px 0px 0px 10px;text-align:left;color:#000000;font-size:14px;">Total:  <strong>{$total_sum}</strong>
</p>
<table cellspacing=1 cellpadding=0 style="margin:10px 0px 0px 10px;float:left;" bgColor=#000000>
    <tr>
        <td class=form-ha><b>No</b></td>
        <td class=form-ha><b>ID</b></td>
        <td class=form-ha><b>Name</b></td>
        <td class=form-ha><b>Total</b></td>
    </tr>
    {foreach item = row from = $balances}
        <tr>
            <td class=form-ta align=right>{$row.num}</td>
            <td class=form-ta align=right>
                <a href="./admin.php?users&id={$row.id}" style="font-weight:normal;color:#000000;font-size:14px;">{$row.id}</a>
            </td>
            <td class=form-ta>
                <a href="./admin.php?users&sort=7&sort_str={$row.id}" style="font-weight:normal;color:#000000;font-size:14px;">{$row.name}</a>
            </td>
            <td class=form-ta align=right>
                <a href="./admin.php?users&bal={$row.id}" style="font-weight:normal;{if $row.summ < 0}color:red;{else}color:#000000;{/if}font-size:14px;">{$row.summ}</a>
            </td>
        </tr>
    {/foreach}
</table>