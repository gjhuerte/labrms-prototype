@extends('layouts.master-blue')
@section('title')
Item Profile
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
{{ HTML::style(asset('css/style.css')) }}
<style>
	#page-body,#page-two{
		display: none;
	}
	.panel-padding{
		padding: 10px;
	}

	.btn-flat {
		padding: 10px;
	}
</style>
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery-ui.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-offset-3 col-md-6 panel panel-body">
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
		{{ Form::open(['method'=>'post','route'=>'item.profile.store','class'=>'form-horizontal','id'=>'profilingForm']) }}
		<ol class="breadcrumb">
		  <li><a href="{{ url('inventory/item') }}">Inventory</a></li>
		  <li><a href="{{ url('inventory/item') }}">Item</a></li>
		  <li class="active">Create</li>
		</ol>
		<div class="col-md-12">
			<p class="align-right pull-right text-muted">Unprofiled Items:<span id="total"></span></p>
		</div>
		<div class="panel panel-body">
			<div id="page-one">
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
						<label for="inventory_id">
							Inventory ID
							<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Details" data-content="This inventory consists of the type of '{{ $inventory->itemtype->name }}' brand of '{{ $inventory->brand }}', and model '{{ $inventory->model }}'" style="text-decoration: none;"></span>
						</label>
						{{ Form::text('inventory_id',$inventory->id,[
							'class' => 'form-control',
							'placeholder' => 'Inventory ID',
							'readonly',
							'style'=>'background-color:white;'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('receipt_id','Acknowledgement Receipt') }}
					{{ Form::select('receipt_id',['List empty'],Input::old('receipt_id'),[
						'class' => 'form-control readonly-white',
						'placeholder' => 'Information ID',
						'readonly',
						'style'=>'background-color:white;'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('date','Date Received') }}
					<input id="dateReceived" class="form-control" placeholder="Date Received" readonly="readonly" name="datereceived" type="text" style="background-color: white;">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12" id="quantity-to-profile-form">
					{{ Form::label('quantity','Quantity To Profile') }}
					{{ Form::number('quantity',Input::old('quantity'),[
						'id' => 'quantity',
						'class' => 'form-control',
						'placeholder' => 'Quantity To Profile'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('location','Location') }}
					{{ Form::select('location',['Loading all locations ..'],Input::old('location'),[
						'id' => 'location',
						'class' => 'form-control',
						'placeholder' => 'Location'
					]) }}
					<p class="text-muted pull-right" style="font-size:10px;"><span class="text-danger">Note:</span> The Default Storage Location is <strong>Server Room</strong></p>
					</div>
				</div>
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="text-decoration: none;">
				          Property Number Helper <span class="pull-right glyphicon glyphicon-triangle-bottom"></span>
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				        <div class="form-group">
				        	<div class="col-sm-12">
					        	{{ Form::label('propertynumber-assitant','Property Number Constant Value Fillers:') }}
					        	<p class="text-muted" style="font-size: 12px;">
					        		This will fill up the 'PUP-'
					        	</p>
					        	<input type="text" class="form-control" id="propertynumber-assitant" />
					        </div>
				        </div>
				        <div class="form-group">
				        	<div class="col-sm-12">
					        	<p class="text-muted" style="font-size: 12px;">
					        		Note: This will append number after the constant value you filled up
					        	</p>
					        	<input type="checkbox" id="is-incrementing" /> Is Incrementing?
					        	<input type="number" placeholder="Starting Value" class="form-control" id="is-incrementing-value" disabled />
					        </div>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="form-group pull-right">
						<div class="col-md-12">
							<button type="button" id="next" class="btn btn-flat btn-primary" style="padding-left: 20px;padding-right: 20px;">Next</button>
						</div>
				</div>
			</div>
			<div id="page-two">
				<table id="itemTable" class="table table-bordered table-hover">
						<thead>
							<th>ID</th>
							<th>Property Number</th>
							<th>Serial ID</th>
						</thead>
						<tbody>
						</tbody>
				</table>
				<div class="form-group pull-right">
					<div class="col-md-12">
						<button type="button" id="previous" class="btn btn-flat btn-default" style="padding-left: 20px;padding-right: 20px;">Previous</button>
					{{ Form::submit('Profile',[
						'class'=> 'btn btn-md btn-flat btn-primary',
						'name' => 'Profile'
					]) }}
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){
		$('#next').on('click',function(){
			quantity = $('#quantity').val()

			if ( quantity == "" ){
				swal('Error Occurred!','Quantity must be greater than zero','error')
			} else if ( quantity == null ){
				swal('Error Occurred!','Quantity must be greater than zero','error')
			} else if ( quantity == 0 ){
				swal('Error Occurred!','Quantity must be greater than zero','error')
			} else if( quantity > parseInt( $('#total').text() ) ) {
				swal('Error Occurred!','Quantity must not be greater than unprofiled items','error')
			} else if( quantity > 50 ) {
				swal('Error Occurred!','Batch process has a limit of 50 items only!','error')
			} else {
				pageOne()
			}
		});

		$('#is-incrementing').on('change',function(){
			if($('#is-incrementing').is(':checked'))
			{

				$('#is-incrementing-value').removeProp('disabled')
			} else {
				$('#is-incrementing-value').prop('disabled','disabled')
			}
		})

		$('#quantity').on('focusin change keyup keypress',function(){
			quantity = $('#quantity').val()

			if(quantity > 50)
			{
					$('#quantity-error').remove()
					$('#quantity').after('<p class="text-danger" id="quantity-error" style="font-size: 12px;">Warning! The system accepts profile up to 50 items only.</p>')

				$('#quantity').val(50)
			}

			if( quantity <= 50 ) {

				$('#quantity-error').fadeOut(400,function(){ $(this).remove() })
			}
		})

		function pageOne()
		{
			$('#page-one').hide(400);
			$('#page-two').show(400);
			$('tbody').html("");

			const1 = "";
			if($('#propertynumber-assitant').val() != "")
			{
				const1 = $('#propertynumber-assitant').val()
			}

			const2 = "";
			if($('#is-incrementing').is(":checked"))
			{
				const2 = $('#is-incrementing-value').val()
			}

			quantity = $('#quantity').val();
			for( var ctr = 1 ; ctr <= quantity ; ctr++ ){
				insertForm(ctr,const1,const2);

				if($('#is-incrementing').is(":checked"))
				{
					const2++
				}
			}

		}

		function pageTwo()
		{
			$('#page-two').hide(400);
			$('#page-one').show(400);
		}

		$('#previous').on('click',function(){
			pageTwo()
		});

	    function insertForm(row,const1 = "",const2 = "")
	    {
	      $('tbody').append(`
				<tr>
					<td>`+row+`</td>
					<td>
						<input type="text" name="item[`+(row-1)+`][propertynumber]" class="form-control" placeholder="Property Number" value="`+ const1 + const2 + `">
					</td>
					<td>
						<input type="text" name="item[`+(row-1)+`][serialid]" class="form-control" placeholder="Serial Number">
					</td>
				</tr>
	      `)
	    }

		$.ajax({
			type: 'get',
			url: '{{ route("item.profile.receipt.all") }}',
			data: { 'id' : {{ (is_numeric($inventory->id)) ? $inventory->id : '-1'; }} },
			dataType: 'json',
			success: function(response){
				var options = '';
				if(response == 'error'){
					var second = 4;

					setInterval(function(){
						swal({
							title: "Oops..",
							text: "Inventory ID not valid! Returning to Item  Inventory in "+second+" seconds",
							showConfirmButton: false

						});
						second -= 1;
					},1000);

					setTimeout(function(){
						window.location.href = '{{ route("inventory.item.index") }}';
					},5000);

				}else if(response.length == 0){

					var second = 4;

					setInterval(function(){
						swal({
							title: "Oops..",
							text: "There are no Acknowledgement Receipt for this item! Returning to Inventory in "+second+" seconds",
							showConfirmButton: false

						});
						second -= 1;
					},1000);

					setTimeout(function(){
						window.location.href = '{{ route("inventory.item.index") }}';
					},5000);

				}else{

					for( ctr = 0 ; ctr < response.length ; ctr++ ){
						options += `<option value=`+response[ctr].id+`>`+response[ctr].number+`</option>`;
					}

					$('#receipt_id').html('');
					$('#receipt_id').append(options);
				}

			},
			error: function(response){
				swal('Oops...','Error ocurred while fetching data','error');
				console.log(response.responseJSON)
			}
		});

		$.ajax({
			type : "get",
			url : "{{ route('room.index') }}",
			dataType : "json",
			success : function(response){
				options = "";
				for(ctr = 0;ctr<response.data.length;ctr++){
					options += `<option value='`+response.data[ctr].name+`'>`+response.data[ctr].name+`</option>'`;
				}

				$('#location').html("");
				$('#location').append(options);
				@if(Input::old('location'))
				$('#location').val({{ "'".Input::old('location')."'" }});
				@else
				$('#location').val('Server');
				@endif
			},
			error : function(response){
				$('#location').html("<option>Loading all locations ...</option>")
				console.log(response.responseJSON);
			}
		});

		$('#propertynumber').on('focus',function(){
			var current = $('#propertynumber').val()
			var constant = "PUP-";
			$('#propertynumber').val( constant + current )
		});

		$( "#dateReceived" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
		});
		$('#inventory-help').click(function(){
			$('#inventory-help').popover('show')
		});

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		@if(Input::old('dateReceived'))
			$('#dateReceived').val({{ Input::old('dateReceived') }});
			setDate("#dateReceived");
		@else
			$('#dateReceived').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
			setDate("#dateReceived");
		@endif

		$('#dateReceived').on('change',function(){
			setDate("#dateReceived");
		});

		$

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}

		$.getJSON( '{{ url("inventory/item/$inventory->id") }}' , function(response){
				$('#total').text(parseInt(response.quantity) - parseInt(response.profileditems));
		})

		$('#page-body').show();
	});
</script>
@stop
