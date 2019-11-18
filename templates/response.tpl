<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12">
<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<span class=nav>{$content_6}</span>
</p>

<table border=0 style="text-align:center; float:right; margin-right: 13px">
	<tr>
		{if $fpagesarr[3]["p"] == "..."}
			<td>
				<a href="./index.php?response&language={$lang_id}&fid={$prev_id}" style="font-size:12px;color:#000;">
					<div style="padding: 2px 5px 2px 5px;color: #000; font-weight:bold; border: 1px solid #ddd;">
						{$content_361}
					</div>
				</a>
			</td>
		{/if}
		{foreach item = row key = k from = $fpagesarr}
			<td>
				{if $row.p <> "..."}
						<a href="./index.php?response&language={$lang_id}&fid={$row.id}" style="color: #000; font-weight:normal; font-size: 12px;">
							<div style="padding: 2px 5px 2px 5px;{if $row.p==$fpage} border: 1px solid #000;background: #efebe3;{else} border: 1px solid #ddd;{/if}">
								{$row.p}
							</div>
						</a>
				{else}
					<div style="padding: 2px 5px 2px 5px;color: #000; font-weight:normal; font-size: 12px;">
						{$row.p}
					</div>
				{/if}
			</td>
		{/foreach}
		{if $fpagesarr[$blok]["p"] == "..." || $fpagesarr[$blok+4]["p"] == "..."}
			<td>
				<a href="./index.php?response&language={$lang_id}&fid={$next_id}" style="font-size:12px;color:#000;">
					<div style="padding: 2px 5px 2px 5px;color: #000; font-weight:bold; border: 1px solid #ddd;">
						{$content_362}
					</div>
				</a>
			</td>
		{/if}
	</tr>
</table>

<p class=user_resp style="margin:30px 15px 30px 15px; padding: 10px;">{$response|nl2br}</p>
</div>
</div>
</div>