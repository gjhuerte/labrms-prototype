<style>

	#page-body, #pagetwo , .transfer, .action-taken{
		display:none;
	}

	.panel-padding{
		padding: 10px;
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
							<select class="form-control" name="type" id="type"></select>
						</div>
					</div>

					<div class="form-group maintenance" id="maintenance-type">
						<div class="col-sm-12">
							{{ Form::label('maintenancetype','Maintenance Type') }}
							<select class="form-control" name="maintenancetype" id="maintenancetype">
								<option value="preventive"> Preventive </option>
								<option value="corrective"> Corrective </option>
							</select>
						</div>
					</div>

					<div class="form-group action-taken">
						<div class="col-sm-12">
							{{ Form::label('incident','Incident Name') }}
							<select class="form-control" name="incident" id="incident">
							</select>
						</div>
					</div>

					<div class="form-group transfer">
						<div class="col-sm-12">
							{{ Form::label('from','Transfer From') }}
							<select class="form-control" name="from" id="from">
							</select>
						</div>
					</div>

					<div class="form-group transfer">
						<div class="col-sm-12">
							{{ Form::label('to','Transfer To') }}
							<select class="form-control" name="to" id="to">
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-9 col-sm-3">
							{{ Form::button('Next',[
							'class'=>'btn-block btn btn-md btn-primary',
							'id' => 'next'
							]) }}
						</div>
					</div>
				</div>

				<div id="pagetwo">

					<div class="form-group maintenance">
						<div class="col-sm-12">
							{{ Form::label('category','Category') }}
							<select class="form-control" name="category" id="category">
								<option> None </option>
							</select>
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
							{{ Form::submit('Generate',[
							'class'=>'btn btn-block btn-md btn-primary'
							]) }}
						</div>
						<div class="col-sm-3">
							{{ Form::button('Back',[
							'class'=>'btn btn-block btn-md btn-info',
							'id' => 'back'
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

		init();

		$('#next').click(function(){
			$('#pageone').hide(500);
			$('#pagetwo').show(500);
			setCategory();
		});

		$('#back').click(function(){
			$('#pagetwo').hide(500);
			$('#pageone').show(500);
		});

		function init(){
			$.ajax({
				type: 'get',
				url: '{{ url("get/ticket/type/all") }}',
				dataType: 'json',
				success: function(response){
			    options = "";
			    if(response.length == 0)
			    {
			      options = "<option>Empty list</option>";

			    }else{
				    for(var ctr = 0;ctr<response.length;ctr++){
				      		options += "<option value="+response[ctr].type+">"+response[ctr].type+"</option>";
				    }
					}

			    $('#type').html(" ");
			    $('#type').append(options);
					$('#type').val('Maintenance');
				}
			});
		}

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

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	});
</script>
