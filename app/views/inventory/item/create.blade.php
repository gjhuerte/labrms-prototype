@extends('layouts.master-blue')
@section('title')
Create
@stop
@section('navbar')
@include('layouts.navbar.admin.default')
@stop
@section('content')
<style>
	.panel-padding{
		padding: 10px;
	}
</style> 
<div class="container-fluid">
	<div class='col-md-12'>     
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
	 		{{ Form::open(['method'=>'post','route'=>'inventory.item.store','class'=>'form-horizontal','id'=>'ticketingForm']) }}
			<div class="panel panel-body">
				<legend><h3 style="color:#337ab7;">Create Item Profile</h3></legend>
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('itemname','Item name') }}
					{{ Form::text('itemname',Input::old('itemname'),[
						'class' => 'form-control',
						'placeholder' => 'Item name',
						'id' => 'itemname'
					]) }}
					</div>	
					<div class="col-sm-12">
					{{ Form::label('type','Item type') }}
					<select class="form-control" name='type' id='type'>
						<option value="Display">Display</option>
						<option value="AVR">AVR</option>
						<option value="Aircon">Aircon</option>
						<option value="TV">TV</option>
						<option value="Projector">Projector</option>
						<option value="Extension">Extension</option>
					</select>
					</div>
					<div class="col-sm-12">
					{{ Form::label('serialid','Serial ID') }}
					{{ Form::text('serialid',Input::old('serialid'),[
						'class' => 'form-control',
						'placeholder' => 'Serial ID'
					]) }}
					</div>		

					<div class="col-sm-12">
					{{ Form::label('propertyid','Property Number') }}
					{{ Form::text('propertyid',Input::old('propertyid'),[
						'class' => 'form-control',
						'placeholder' => 'Property Number'
					]) }}
					</div>

					<div class="col-sm-12">
					{{ Form::label('MR_no','MR Number') }}
					{{ Form::text('MR_no',Input::old('MR_no'),[
						'class' => 'form-control',
						'placeholder' => 'MR Number'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('description','Details') }}
						{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter ticket details here...'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-4">
					{{ Form::submit('Create',[
						'class'=> 'btn btn-primary btn-block',
						'name' => 'create'
					]) }}
					</div>
					<div class="col-md-4">
					{{ Form::button('Clear',[
						'name' => 'clear',
						'id' => 'clear',
						'class'=>'btn btn-info btn-block'
					]) }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

  $('#clear').click(function(){
  	$('#ticketingForm').trigger('reset')
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
</script>
@stop