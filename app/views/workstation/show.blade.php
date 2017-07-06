@extends('layouts.master-blue')
@section('title')
Workstation Profile
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6">
	@if(count($pc) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Workstation Profile</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-4">
					<label class="text-primary">Name</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $pc->name }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">System Unit</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $pc->systemunit->inventory->itemname }} - {{ $pc->systemunit->property_number }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Display</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $pc->display->inventory->itemname }} - {{ $pc->display->property_number }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Keyboard</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ ($pc->keyboard) ? "yes" : "no" }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Mouse</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ ($pc->mouse) ? "yes" : "no" }}</p>
				</div>
				<div class="col-md-12">
					<div class="pull-right">
					{{ Form::open(['method'=>'delete','route'=>array('workstation.destroy',$pc->id)]) }}	
					{{ Form::submit('Delete',[
						'class' => 'btn btn-warning',
						'name' => 'delete'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'get','route'=>array('workstation.edit',$pc->id)]) }}
					{{ Form::submit('Transfer',[
						'class'=>'btn btn-success',
						'name' => 'transfer'
					]) }}
					{{ Form::close() }}
					</div>
					<div class="pull-right">
					{{ Form::open(['method'=>'get','route'=>array('workstation.edit',$pc->id)]) }}
					{{ Form::submit('Update',[
						'class'=>'btn btn-primary',
						'name' => 'update'
					]) }}
					{{ Form::close() }}
					</div>
				</div>
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#complaintCOllapse" aria-expanded="false" aria-controls="complaintCOllapse">
					  <legend><strong class="text-primary">Complaints</strong></legend>
					</a>
					<div class="collapse" id="complaintCOllapse">
					  <div class="well">
					  </div>
					</div>
				</div>
				<hr />
				<div class="col-md-12" style="padding-top: 20px;">
					<a class="btn-link" role="button" data-toggle="collapse" href="#historyCollapse" aria-expanded="false" aria-controls="historyCollapse">
					  <legend><strong class="text-primary">History</strong></legend>
					</a>
					<div class="collapse" id="historyCollapse">
					  <div class="well">
					  </div>
					</div>
				</div>
			</div>
		</div>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
