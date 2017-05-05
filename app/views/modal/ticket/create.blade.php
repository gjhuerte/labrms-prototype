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
						{{ Form::label('itemname','Item name') }}
						<select class="form-control" name="itemname" id="itemname">
						</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('property_number','Property Number') }}
							<select class="form-control" name="property_number" id="property_number">
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('type','Ticket Type') }}
							<select class="form-control" name="type" id="type">
							<option value="maintenance"> Maintenance </option>
							<option value="borrow"> Lent </option>
							<option value="incident"> Incident </option>
							<option value="actiontaken"> Action Taken </option>
							<option value="transfer"> Transfer </option>
							<option value="return"> Return </option>
							</select>
						</div>
					</div>

					<div class="form-group maintenance" id="maintenance-type">
						<div class="col-sm-12">
							{{ Form::label('maintenancetype','Maintenance Type') }}
							<select class="form-control" name="maintenancetype" id="maintenancetype">
								<option> Preventive </option>
								<option> Corrective </option>
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

					<div class="form-group maintenance" id="category">
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

		$('#next').click(function(){
			$('#pageone').hide(500);
			$('#pagetwo').show(500);
		});

		$('#back').click(function(){
			$('#pagetwo').hide(500);
			$('#pageone').show(500);
		});

		$('#clear').click(function(){
			$('#maintenanceForm').trigger('reset');
		});

		$('#type').change(function(){
			var type = $('#type').val();
			if(type == 'maintenance')
			{
				$('.action-taken').hide(200);
				$('.transfer').hide(200);
				$('.maintenance').show(200);
			}else if(type == 'transfer'){
				$('.transfer').show(200);
				$('.action-taken').hide(200);
				$('.maintenance').hide(200);
			}else if(type == 'actiontaken'){
				$('.transfer').hide(200);
				$('.maintenance').hide(200);
				$('.action-taken').show(200);
			}else{
				$('.action-taken').hide(200);
				$('.transfer').hide(200);
				$('.maintenance').hide(200);
			}
		});

		$('#itemname').change(function(){
		propertyNumberAjaxRequest();
		});

		$(document).ready(function(){
		propertyNumberAjaxRequest();
		});

		function propertyNumberAjaxRequest(){
		var itemname = $('#itemname').val();
		$.ajax({
		  type: 'post',
		  url: '{{ url('/getAllPropertyNumber') }}',
		  data: {'itemname' : itemname}, 
		  dataType: 'json',
		  success: function(response){ 
		    options = "";
		    if(!$.trim(response))
		    {
		      options = "<option>Empty list</option>";

		    }else{
			    for(var ctr = 0;ctr<response.length;ctr++){
			      		options += "<option value="+response[ctr].id+">"+response[ctr].property_number+"</option>";
			    }
		    }   
		    $('#property_number').html(" ");
		    $('#property_number').append(options);
		  },
		  error: function(response){
		    console.log(response.responseJSON);
		  }
		 });
		}

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	});

	$( document ).ajaxComplete(function() {
		$('#page-body').slideDown(200);
	});
</script>