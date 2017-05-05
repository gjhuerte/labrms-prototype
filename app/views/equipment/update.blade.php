@extends('layouts.master-blue')
@section('title')
Update
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
				{{ Form::model($item,array('route'=>array('equipment.update',$item->id),'method'=>'PUT',
	            'class' => 'form-horizontal'
	          )) }}
			<div class="panel panel-body">
				<legend><h3 style="color:#337ab7;">Update Equipment Information</h3></legend>
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
						'placeholder' => 'Property Number',
						'id' => 'propertyid'
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
					<div class="col-md-offset-8 col-md-4">
					{{ Form::submit('Update',[
						'class'=> 'btn btn-primary btn-block',
						'name' => 'create'
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
@if(!empty($item))
	$('#propertyid').val('{{ $item->property_number }}');
	$('#itemname').val('{{ $item->inventory->first()->itemname }}')
	$('#type').val('{{ $item->type }}')
@endif
  @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
  @endif
  @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
  @endif
</script>
@stop