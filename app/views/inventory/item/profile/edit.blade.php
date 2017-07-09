@extends('layouts.master-blue')
@section('title')
Item Profile
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('style')
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
<style>
	#page-body{
		display: none;
	}
	.panel-padding{
		padding: 10px;
	}
</style>
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery-ui.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-md-offset-3 col-md-6 '>
		<div class="panel panel-body">
			<ol class="breadcrumb" style="background-color: white;">
				<li><a href="{{ url('inventory/item') }}">Inventory</a></li>
				<li><a href="{{ url('inventory/item') }}">Item</a></li>
				<li><a href="{{ route('item.profile.show',$itemprofile->inventory_id) }}">{{{ $itemprofile->inventory_id }}}</a></li>
				<li class="active">Update</li>
			</ol>
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
			{{ Form::open(['method'=>'put','route'=>array('item.profile.update',$itemprofile->id),'class'=>'form-horizontal','id'=>'profilingForm']) }}
			<div class="col-md-12" style="padding:10px;">
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
					<label for="inventory_id">
						Inventory ID
						<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Details" data-content="This inventory consists of the type of '{{ $itemprofile->inventory->itemtype->name }}' brand of '{{ $itemprofile->inventory->brand }}', and model '{{ $itemprofile->inventory->model }}'" style="text-decoration: none;"></span>
					</label>
					{{ Form::text('inventory_id',$itemprofile->inventory_id,[
						'class' => 'form-control',
						'placeholder' => 'Inventory ID',
						'readonly',
						'disabled',
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
					{{ Form::label('propertyid','Property Number') }}
					{{ Form::text('propertyid',Input::old('propertyid'),[
						'class' => 'form-control',
						'id' => 'propertyid',
						'placeholder' => 'Property Number'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('serialid','Serial Number') }}
					{{ Form::text('serialid',Input::old('serialid'),[
						'class' => 'form-control',
						'id' => 'serialid',
						'placeholder' => 'Serial Number'
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
				<div class="form-group">
					<div class="col-md-12">
							{{ Form::submit('Update',[
								'class'=> 'btn btn-primary btn-block btn-lg',
								'name' => 'Profile'
							]) }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript">
	$(document).ready(function(){
		//fetch all data ...
		$.ajax({
			type: 'get',
			url: '{{ url("get/item/profile/receipt/all") }}',
			data: { 'id' : {{ (is_numeric($itemprofile->inventory_id)) ? $itemprofile->inventory_id : '-1'; }} },
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
			},
			complete: function(){
				$('#propertyid').val('{{ $itemprofile->propertynumber }}');
				$('#serialid').val('{{ $itemprofile->serialnumber }}');
			}
		});

		$.ajax({
			type : "get",
			url : "{{ route('room.index') }}",
			dataType : "json",
			success : function(response){
				options = "";
				for(ctr = 0;ctr<response.data.length;ctr++){
					options += `<option value='`+response.data[ctr].id+`'>`+response.data[ctr].name+`</option>'`;
				}

				$('#location').html("");
				$('#location').append(options);
			},
			error : function(response){
				$('#location').html("<option>Loading all locations ...</option>")
			},
			complete: function(){
				@if($room = Room::where('name','=',$itemprofile->location)->first())
				$('#location').val('{{ $room->id }}')
				@elseif(Input::old('location'))
				$('#location').val('{{ Input::old('location') }}')
				@endif
			}
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

		@if(Input::old('dateReceived'))
			$('#dateReceived').val({{ Input::old('dateReceived') }});
			setDate("#dateReceived");
		@elseif($itemprofile->datereceived)
			$('#dateReceived').val("{{ Carbon\Carbon::parse($itemprofile->datereceived)->toFormattedDateString() }}");
			setDate("#dateReceived");
		@else
			$('#dateReceived').val({{ "'".Carbon\Carbon::now()->toFormattedDateString()."'" }});
		@endif

		$('#dateReceived').on('change',function(){
			setDate("#dateReceived");
		});

		function setDate(object){
				var object_val = $(object).val()
				var date = moment(object_val).format('MMM DD, YYYY');
				$(object).val(date);
		}

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#page-body').show();
	});
</script>
@stop
