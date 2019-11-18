<section class="offers">
		<div class="container">
			<div class="row">
				<div class="col-4">
					<div class="danger">
						<h2>{$content_315}</h2>
					</div>
				</div>
				<div class="col-4 offset-4">
					<div class="goto">
						<a href="./index.php?hotpr">{$content_316} <i class="fas fa-angle-double-right"></i> </a>
					</div>
				</div>
			</div>
			<div class="row">
				{foreach item = row from = $hotpr}
					<div class="col-3">
						<div class="offers-blocks" onclick="window.location='./index.php?hotpr=1&prid={$row.id}';">
							<!-- <h3>{$row.name}</h3> -->
							<img src="{if $row.photo}./get_image.php?w=226&h=168&pic={$row.photo}&{$row.dt}{else}./pics/no_foto.gif{/if}" width=100% alt="{$row.name}">
							<p class="text-">
								<span class="f-bold">{$content_460}:</span>
								{$row.mark}
							</p>
							<p class="text-">
								<span class="f-bold">{$content_461}:</span>
								{$row.model}
							</p>
							<p class="text-">
								<span class="f-bold">{$content_462}:</span>
								{$row.year}
							</p>
							<p class="text-">
								<span class="f-bold">{$content_463}:</span>
								{$row.engine}
							</p>
							<p class="text-">
								<span class="f-bold">{$content_464}:</span>
								{$row.chassis}
							</p>
							<p class="text-">
								<span class="f-bold">{$content_467}:</span>
								{$row.mileage}
							</p>
							<h2>{$row.amount}</h2>
							<p>{$row.notes}...&nbsp;<a href="./index.php?hotpr&id={$row.id}">{$content_317}</a></p>
						</div>
					</div>
				{/foreach}
			</div>
	        </div>
</section>

