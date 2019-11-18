{if $part=="auc_elements"}
    <select class="button2" size=1
            onChange="window.location='https://carvector.com/car-search/?lang='+this.value;">
        {foreach item = row from = $languages}
            <option value="{$row.iso_code}"{if $lang_code==$row.iso_code} selected{/if}>
                {$row.name}
            </option>
        {/foreach}
    </select>
{else}
    <select class="button2" size=1
            onChange="window.location='{$siteRoot}/index.php?language='+this.value;">
        {foreach item = row from = $languages}
            <option value="{$row.id}"{if $lang_id==$row.id} selected{/if}>
                {$row.name}
            </option>
        {/foreach}
    </select>
{/if}
