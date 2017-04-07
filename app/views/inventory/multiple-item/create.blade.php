@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('script-include')
	{{ HTML::script(asset('js/bootstrap-toggle.min.js')) }}
@stop
@section('style-include')
	{{ HTML::style(asset('css/bootstrap-toggle.min.css')) }}
@stop
@section('content')
<style>
	#two, #page-body, #itemname-text { display: none; }
	.panel-padding{
		padding: 10px;
	}
</style> 
<div class="container-fluid" id="page-body">
	<div class='col-md-12'>     
		<div id="page-column" class="col-md-offset-3 col-md-6 panel panel-body">
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
	 		{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'inventoryForm']) }}
			<div class="panel panel-body">
				<legend><h3 style="color:#337ab7;">Create Item Profile</h3></legend>
				<div id="one">
					<div class="form-group">
						<div class='col-sm-12'>
							{{ Form::label('MR_no','Memorandum Receipt Number (M.R. No ) ') }}
							<input class='form-control' placeholder='MR Number' name='MR_no' type='text' id='MR_no'>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-4">
						{{ Form::label('Item name') }}
						</div>
						<div class="col-sm-4">
						{{ Form::radio('existing','true',true,[
							'id' => 'existing'
						]) }} Existing
						</div>
						<div class="col-sm-4">
						{{ Form::radio('existing','false',false,[
							'id' => 'not-existing'
						]) }} Not Existing
						</div>
						<div class="col-sm-12" id="itemname-text">
						{{ Form::text('itemname',Input::old('itemname'),[
							'class' => 'form-control',
							'placeholder' => 'Item name'
						]) }}
						</div>
						<div class="col-sm-12" id="itemname-select">
						{{ Form::select('itemname',[''=>''],Input::old('itemname'),[
							'class'=>'form-control'
						]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('type','Item type') }}
							{{ Form::select('type',['Empty list'=>'Empty list'],Input::old('itemname'),[
								'id'=>'type',
								'class'=>'form-control'
							]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::label('quantity','Quantity') }}
							{{ Form::number('quantity',Input::old('quantity'),[
								'class' => 'form-control',
								'placeholder' => 'Quantity',
								'id' => 'quantity'
							]) }}
						</div>	
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-4">
						{{ Form::button('Next',[
							'class'=> 'btn btn-primary btn-block',
							'name' => 'next',
							'id' => 'next'
						]) }}
						</div>
						<div class="col-md-4">
						{{ Form::button('Cancel',[
							'name' => 'cancel',
							'id' => 'cancel',
							'class'=>'btn btn-info btn-block'
						]) }}
						</div>
					</div>
				</div>
				<div id="two">
					<div id="item"></div>
					<div class="form-group">
						<div class="col-md-offset-6 col-md-3">
						{{ Form::button('Create',[
							'class'=> 'btn btn-primary btn-block',
							'name' => 'create',
							'id'=>'create'
						]) }}
						</div>
						<div class="col-md-3">
						{{ Form::button('Back',[
							'class'=> 'btn btn-info btn-block',
							'name' => 'back',
							'id' => 'back'
						]) }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){

		$('#existing').click(function(){
			$('#itemname-text').hide(400);
			$('#itemname-select').show(400);
		});

		$('#not-existing').click(function(){
			$('#itemname-select').hide(400);
			$('#itemname-text').show(400);
		});

		$('#next').click(function(){
			var quantity = $('#quantity').val();
			var itemname = $('#itemname').val();
			var mrnumber = $('#MR_no').val();
			if(mrnumber == false){
		  		swal("Oops...","MR Number must not be empty","error");
			}else if(itemname == false){
		  		swal("Oops...","Item name must not be empty","error");
			}else if(isNaN(quantity) || quantity == false){
		  		swal("Oops...","Quantity field must have a number","error");
			}else{
				$('#two').fadeIn(200);
				$('#one').hide(100);
				itemFieldAjaxRequest();
			}
		});

		$('#back').click(function(){
			$('#two').hide(100);
			$('#one').fadeIn(200);
		});

		function itemFieldAjaxRequest(){
			var quantity = $('#quantity').val();
			$.ajax({
			  type: 'post',
			  url: '{{ url('/getItemField') }}',
			  data: {'quantity' : quantity}, 
			  dataType: 'html',
			  success: function(response){ 
			    $('#item').html(" ");
			    $('#item').append(response).hide().fadeIn('slow');
			  },
			  error: function(response){
			    console.log(response.responseJSON);
			  }
			 });
		}

		$('#cancel').click(function(){
			window.location.replace('{{ route('inventory.item.index') }}');
		});

		$('#create').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "This process is irreversible, do you want to continue?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonText: "Yes, i want to submit it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
			    $("#inventoryForm").submit();
			  } else {
			    swal("Cancelled", "Profiling Cancelled", "error");
			  }
			});
		});

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		@if(!empty($itemname))
			$('#itemname').val('{{ $itemname }}');
		@endif
		@if(!empty($itemtype))
		  	$('#type').val('{{ $itemtype }}');
		@endif
	});

	$(document).ready(function(){
		$.ajax({
			type: 'post',
			url: '{{ url('/getAllItemTypes') }}',
			dataType: 'json',
			beforeSend: function(){
				$('#page-body').slideUp(0);
			},
			success: function(response){ 
			    options = "";
			    if(!$.trim(response))
			    {
			      options = "<option>Empty list</option>";

			    }else{
				    for(var ctr = 0;ctr<response.length;ctr++){
				      		options += "<option value="+response[ctr].type+">"+response[ctr].type+"</option>";
				    }
			    }   
				$('#type').html(" ");
				$('#type').append(options).fadeIn(0);
			},
			error: function(response){
			console.log(response.responseJSON);
			},
			complete: function(){
				$('#page-body').slideDown(400);
			}
		});
	});
</script>
@stop