<div class="container min-h-500">
	<div class="row">
		<div clas="col-xl-12 col-lg-12">
		{if $id}
			<p style="font-size:14px;margin:10px 10px 0px 10px;">
				<a href="./index.php?service" class=nav>{$content_8}</a>
				&nbsp;&#187;&nbsp;
				<span class=nav>{$service_name}</span>
			</p>
			<div style="font-size:14px;padding:10px 10px 20px 10px">{$value}</div>
		{else}
			<p style="font-size:14px;margin:10px 10px 0px 10px;">
				<span class=nav>{$content_8}</span>
			</p>
			{foreach item = row from = $services}
				<p style="margin:25px 10px 20px 70px;">
					<a style="color:#000000;font-size:15px;" href="./index.php?service&id={$row.id}">{$row.value}</a>
				</p>
			{/foreach}
			<br>
			<br>
		{/if}

		</div>
	</div>
</div>
