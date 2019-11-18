<div class="container min-h-500">
	<div class="row">
		<div clas="col-xl-12 col-lg-12">
			<table width=100% height=100% cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td valign="top">
						<p style="margin:10px 10px 20px 10px;font-size:14px;">
							{if $id}
								<a href="./index.php?faq" class=nav>{$content_7}</a>
								<br><br>
								<b>{$quest}</b><br>
								<div style="font-size:14px;padding:0px 10px 0px 10px;">{$answer}</div>
								{else}
									<span class=nav>{$content_7}</span>
									<br><br>
									{foreach item = row from = $faqs}
										<a style="color:#000000;font-size:15px;" href="./index.php?faq&id={$row.id}">{$row.quest}</a><br>
										<span style="font-size:3px;"><br></span>
									{/foreach}
							{/if}
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
			

