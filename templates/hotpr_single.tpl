	<style>
	.descr-style {
		/*height: 100%;*/
		padding: 20px;
		border: 1px solid #DDD;
		-webkit-box-shadow: 3px 5px 30px 3px rgba(0,0,0,0.3);
		-moz-box-shadow: 3px 5px 30px 3px rgba(0,0,0,0.3);
		-o-box-shadow: 3px 5px 30px 3px rgba(0,0,0,0.3);
		box-shadow: 3px 5px 30px 3px rgba(0,0,0,0.3);
	}
	.descr-style p {
		margin: 5px 0;
	}
	.descr-style .r-title {
		font-weight: 700;
	}
	.bg-light-orange {
	}
	.descr_full {
		background: #FFDBDB;
		border-radius: 10px;
	}
	.form-control:hover {
		cursor: text;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-lg-8 my-3">
				<div class="col-lg-12 text-left">
					<img width="100%" src="{if $hotpr_data.photo}./get_image.php?w=300&h=200&pic={$hotpr_data.photo}&{$hotpr_data.dt}{else}./pics/no_foto.gif{/if}" alt="{$hotpr_data.name}">
				</div>
				
			<div class="row m-0 p-0  d-none">
				<div class="col-lg-12 my-3">
					<div class="h3">Lorem ipsum dolor</div>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi molestias eius beatae quos veniam, consequatur accusantium minus quae. Dolorem delectus est deleniti fugiat doloremque distinctio, voluptas accusamus beatae dolores sit quaerat dolore, deserunt perferendis dolorum inventore hic iste? Enim, voluptate.
					</p>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-3 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
				<div class="col-lg-12 px-1 my-3">
					<div class="p-2 descr_full">
						<div class="h3">Title</div>
						<p>
							text
							<br>text
							<br>text
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4 my-3">
			<div class="descr-style">
				<div class="h3">{$content_474}:</div>

				<p>
					<span class="r-title">{$content_460}:</span>
					{$hotpr_data.mark}
				</p>
				<p>
					<span class="r-title">{$content_461}:</span>
					{$hotpr_data.model}

				</p>
				<p>
					<span class="r-title">{$content_462}:</span>
					{$hotpr_data.year}

				</p>
				<p>
					<span class="r-title">{$content_463}:</span>
					{$hotpr_data.engine}

				</p>
				<p>
					<span class="r-title">{$content_464}:</span>
					{$hotpr_data.chassis}

				</p>
				<p>
					<span class="r-title">{$content_465}:</span>
					{$hotpr_data.color}

				</p>
				<p>
					<span class="r-title">{$content_466}: </span>
					{$hotpr_data.transmission}

				</p>
				<p>
					<span class="r-title">{$content_467}:</span>
					{$hotpr_data.mileage}

				</p>
				<p>
					<span class="r-title">{$content_468}:</span>
					{$hotpr_data.fuel}

				</p>
				<p>
					<span class="r-title">{$content_469}:</span>
					{$hotpr_data.note}

				</p>
				<p>
					<span class="r-title">{$content_470}:</span>
					<span class="text-success">{$hotpr_data.delivery}</span>
				</p>
				<p>
					<span class="r-title">{$content_471}:</span>

					<span class="text-danger">{$hotpr_data.amount}</span>

				</p>

				<p class="my-3">
					{$content_472}
					<br>
					<br>
					{$content_473}
				</p>
				<button class="btn btn-block btn-success" data-toggle="modal" data-target="#requestModal">{$content_475}</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="requestModalTitle">{$hotpr_data.name}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="responseDiv" class="text-center">

				</div>
				<div id="requestDiv">
					<form method="POST" action="" id="requestForm">
						<div class="col-lg-12">
							<input type="hidden" name="requestHiddenId" value="{$hotpr_data.id}">
							<input type="hidden" name="requestHiddenName" value="{$hotpr_data.name}">
							<input type="hidden" name="requestHiddenModel" value="{$hotpr_data.model}">
							<div class="form-group">
								<label>{$content_476}:</label>
								<input type="text" class="form-control" name="requestUserName" placeholder="{$content_479}">
							</div>
							<div class="form-group">
								<label>{$content_477}:</label>
								<input type="email" class="form-control" name="requestUserEmail" placeholder="{$content_480}">
							</div>
							<div class="form-group">
								<label>{$content_478}:</label>
								<textarea  class="form-control" name="requestUserMessage" cols="30" rows="3"></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{$content_481}</button>
				<button type="button" class="btn btn-success" id="requestSend">{$content_482}</button>
			</div>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {
		$("#requestSend").click(
			function(){
				sendAjaxForm();
				return false; 
			}
			);
	});

	function sendAjaxForm() {
		jQuery.ajax({
	        url:     'scripts/hotpr_mail.php', //url страницы (action_ajax_form.php)
	        type:     "POST", //метод отправки
	        dataType: "html", //формат данных
	        data: $("#requestForm").serialize(),  // Сеарилизуем объект
	        success: function(response) { //Данные отправлены успешно
	        	result = $.parseJSON(response);
	        	if (result.status == 'success') {
	        		$('#requestDiv').empty();
	        		$('#responseDiv').empty();

	        		$('#requestSend').remove();
	        		$('#responseDiv').append('<h3 class="text-success">' + result.message + '</h3>');
	        	}
	        	else
	        	{
	        		$('#responseDiv').empty();
	        		$('#responseDiv').append('<h3 class="text-danger">' + result.message + '</h3>');
	        	}
	        },
	    	error: function(response) { // Данные не отправлены
	    		$('#responseDiv').html('Ошибка. Данные не отправлены.');
	    	}
	    });
	}
</script>