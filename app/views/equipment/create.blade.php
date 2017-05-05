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
	#page-body{
		display: none;
	}
</style>
<div class="container-fluid" id="page-body">
	@include('equipment.sidebar.default')
	<div class='col-md-7'>     
		<div class="panel panel-body">
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
			{{ Form::open(['method'=>'post','route'=>'equipment.store','class'=>'form-horizontal','id'=>'ticketingForm']) }}
			<div class="panel panel-body">
				<legend><h3 style="color:#337ab7;">Equipment Profile Creation Form</h3></legend>
				<!-- item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('itemname','Item name') }}
					{{ Form::text('itemname',Input::old('itemname'),[
						'class' => 'form-control',
						'placeholder' => 'Item name'
					]) }}
					</div>	
					<div class="col-sm-12">
					{{ Form::label('type','Item type') }}
					<select class="form-control" name='type'>
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
	<div class="col-md-3">
		<div class="panel panel-primary" style="border: none;border-radius: 0px;">
			<div class="panel-heading">
				Important Notes
			</div>
			<div class="panel-body">
				<dl>
					<dt class="bg-info text-info" style="padding: 10px;margin: 10px;">Equipment types</dt>
					<dd class="text-muted" style="padding: 10px;margin: 10px;">
						<ul>
							<li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseHead" aria-expanded="true" aria-controls="collapseHead">
								<strong>Laboratory Head</strong>:<br />
								<span id="collapseHead" class="panel-collapse collapse out" aria-labelledby="headingOne"> Manage reports and system maintenance. Whenever he/she creates a reservation, automatically cancels other reservation where it falls. The head is the <strong>only</strong> one capable of altering accounts.</span>
							</li>
							<li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseAssistant" aria-expanded="true" aria-controls="collapseAssistant">
								<strong>Laboratory Assistant</strong>:<br />
								<span id="collapseAssistant" class="panel-collapse collapse out" aria-labelledby="headingOne"> responsible for all the equipments and rooms under reservation. He/She logs the borrowed item information. The assistant can add accounts and profile each equipment </span>
							</li>
							<li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseStaff" aria-expanded="true" aria-controls="collapseStaff">
								<strong>Laboratory Staff</strong>:<br />
								<span id="collapseStaff" class="panel-collapse collapse out" aria-labelledby="headingOne">  Other personnel under the laboratory department. He/She can profile equipments, accepts complaints, and resolve them.  </span>
							</li>
							<li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseFaculty" aria-expanded="true" aria-controls="collapseFaculty">
								<strong>Faculty</strong>:<br />
								<span id="collapseFaculty" class="panel-collapse collapse out" aria-labelledby="headingOne"> Can complain and has responsibility for reserved items</span>
							</li>
							<li class="text-muted text-justify" data-toggle="collapse" data-parent="#accordion" href="#collapseStudent" aria-expanded="true" aria-controls="collapseStudent">
								<strong>Student</strong>:<br />
								<span id="collapseStudent" class="panel-collapse collapse out" aria-labelledby="headingOne"> Consists of class president ( or any other representative for a class ). He / She can reserve specific items under the jurisdiction of the professor in-charge</span>
							</li>
						</ul>
					</dd>
				</dl>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#page-body').show();
		$('#clear').click(function(){
			$('#ticketingForm').trigger('reset')
		});

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	});
</script>
@stop