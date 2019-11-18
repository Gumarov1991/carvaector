<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<a href="./index.php?account" class=nav>{$content_261}</a>
	{if $direct_model}
		&nbsp;&#187;&nbsp;
		<a href="./index.php?direct" class=nav>{$content_409}</a>
		&nbsp;&#187;&nbsp;
		<a href="./index.php?direct&list" class=nav>{$content_411}</a>
		&nbsp;&#187;&nbsp;
		<span class=nav>{$direct_model_id}</span>
	{else}
		{if $direct_list}
			&nbsp;&#187;&nbsp;
			<a href="./index.php?direct" class=nav>{$content_409}</a>
			&nbsp;&#187;&nbsp;
			<span class=nav>{$content_411}</span>
		{else}
			&nbsp;&#187;&nbsp;
			<span class=nav>{$content_409}</span>
		{/if}
	{/if}
</p>
{if $direct_list && !$direct_model}
	<p style="margin:10px 0px 5px 0px;" align=center>
		{$page_result}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		{if $page>1}<a style="color:#000000;text-decoration: underline;" href="./index.php?direct&stx={$page-1}">{/if}
		{$content_361}
		{if $page>1}</a>{/if}
		&nbsp;|&nbsp;
		{if $next_page}<a style="color:#000000;text-decoration: underline;" href="./index.php?direct&stx={$page+1}">{/if}
		{$content_362}
		{if $next_page}</a>{/if}
	</p>
{/if}
{$direct_page}
{if $direct_list && !$direct_model}
	<p style="margin:10px 0px 5px 0px;" align=center>
		{$page_result}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		{if $page>1}<a style="color:#000000;text-decoration: underline;" href="./index.php?direct&stx={$page-1}">{/if}
		{$content_361}
		{if $page>1}</a>{/if}
		&nbsp;|&nbsp;
		{if $next_page}<a style="color:#000000;text-decoration: underline;" href="./index.php?direct&stx={$page+1}">{/if}
		{$content_362}
		{if $next_page}</a>{/if}
	</p>
{/if}
