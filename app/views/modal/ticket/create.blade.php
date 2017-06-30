<style>

	#pagetwo , .transfer, .action-taken{
		display:none;
	}

</style>

<div class="modal fade" id="generateTicketModal" tabindex="-1" role="dialog" aria-labelledby="generateTicketModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			@if (count($errors) > 0)
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<ul style='margin-left: 10px;'>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			@endif
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Generate Ticket</h3>
			</div>
			<div class="modal-body">
			{{ Form::open(['method'=>'post','route'=>'ticket.store','class'=>'form-horizontal','id'=>'ticketForm']) }}
				<div id="pageone">

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('property_number','Property Number') }}
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="Before creating a ticket, you need to enter the property number of the item you want to generate a ticket to. To prevent furthur problems with generating ticket, you can verify whether the property number exists before proceeding. " tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
						</div>
						<div class="col-sm-9">
						{{ Form::text('propertynumber',Input::old('propertynumber'),[
								'id' => 'propertynumber',
								'class' => 'form-control',
								'required'
							]) }}
						</div>
						<div class="col-sm-3">
							<button type="button" id="check-propertynumber" class="btn btn-block btn-default">Verify</button>
						</div>
						<div class="col-md-12" hidden>
							<p class="text-danger" style="font-size: 10px;">This property doesnt seem to exists. Profile it first before generating a ticket</p>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('type','Ticket Type') }}
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="
								Each ticket type has corresponding action. Choose the correct ticket for the ticket you want to generate to" tabindex="0" data-trigger="focus" style="text-decoration: none;">		</span>
							<select class="form-control" name="type" id="type">
								<option value="maintenance">Maintenance</option>
								<option value="complaint">Complaints</option>
							</select>
						</div>
					</div>

					<div class="form-group maintenance" id="maintenance-type">
						<div class="col-sm-12">
							{{ Form::label('maintenancetype','Maintenance Type') }}
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="
							To furthur clarify the maintenance you want to generate, you need to select the maintenance type. Maintenance type consists of preventive, before any damage could be done, and corrective maintenance for repairs." tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
							<select class="form-control" name="maintenancetype" id="maintenancetype">
								<option value="preventive"> Preventive </option>
								<option value="corrective"> Corrective </option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-9 col-sm-3">
							{{ Form::button('Next',[
							'class'=>'btn-block btn-flat btn btn-md btn-primary',
							'id' => 'next',
							'style'=>'padding: 10px'
							]) }}
						</div>
					</div>
				</div>

				<div id="pagetwo">

					<div class="form-group maintenance">
						<div class="col-sm-12">
							{{ Form::label('category','Category') }}
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="You need to clarify the category/repairs you've done to the item" tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
							<select class="form-control" name="category" id="category">
								<option> None </option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('author','Author') }}
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="The ticket author is the person who request for this ticket to be generated. If the ticket has no author, you can leave this field blank" tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
							{{ Form::text('author',Input::old('author'),[
							'class'=>'form-control',
							'placeholder'=>'Name of the author'
							]) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('description','Details') }}
							{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter ticket details here...'
							]) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-6 col-sm-3">
							{{ Form::button('Back',[
							'class'=>'btn btn-block btn-flat btn-md btn-default',
							'id' => 'back',
							'style'=>'padding: 10px'
							]) }}
						</div>
						<div class="col-sm-3">
							{{ Form::submit('Generate',[
							'class'=>'btn btn-block btn-flat btn-md btn-primary',
							'style'=>'padding: 10px'
							]) }}
						</div>
					</div>
				</div> <!-- end of page-two -->
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
	$(document).ready(function(){

		$('#next').click(function(){
			$('#pageone').hide(500);
			$('#pagetwo').show(500);
			setCategory();
		});

		$('#back').click(function(){
			$('#pagetwo').hide(500);
			$('#pageone').show(500);
		});

		function setCategory()
		{
			var type = $('#maintenancetype').val();
			$.ajax({
				type: 'get',
				url: '{{ url("get/equipment/support") }}' + '/' + type,
				dataType: 'json',
				success: function(response){
			    options = "";
			    if(response.length == 0)
			    {
			      options = "<option>Empty list</option>";

			    }else{
				    for(var ctr = 0;ctr<response.length;ctr++){
				      		options += "<option value="+response[ctr].problem+">"+response[ctr].problem+"</option>";
				    }
					}

			    $('#category').html(" ");
			    $('#category').append(options);
				}
			});
		}

		$('#type').change(function(){
			var type = $('#type').val();
			if(type == 'Maintenance')
			{
				$('.action-taken').hide(200);
				$('.transfer').hide(200);
				$('.maintenance').show(200);
			}else if(type == 'Transfer'){
				$('.transfer').show(200);
				$('.action-taken').hide(200);
				$('.maintenance').hide(200);
			}else if(type == 'Action Taken'){
				$('.transfer').hide(200);
				$('.maintenance').hide(200);
				$('.action-taken').show(200);
			}else{
				$('.action-taken').hide(200);
				$('.transfer').hide(200);
				$('.maintenance').hide(200);
			}
		});


    	$('[data-toggle="popover"]').popover();

	});
</script>
