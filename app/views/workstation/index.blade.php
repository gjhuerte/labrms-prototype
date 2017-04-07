@extends('layouts.master-blue')
@section('title')
Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-1 col-md-3 col-sm-3 panel panel-body" style="background-color:white; padding: 10px;">
		<div class="col-md-8 text-primary">Create workstation</div>
		<div class="col-md-4">
			{{ Form::open(['method'=> 'get','route' => 'workstation.create']) }}
			{{ Form::submit('Create',[
				'class' => 'btn btn-primary btn-block'
			]) }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="clearfix" style="margin: 5px;"></div>
	<div class="col-md-offset-1 col-md-10" style="background-color:white;padding: 30px;">
		<table class="table table-hover table-striped" id="workstationTable">
			<thead>
				<th>Name</th>
				<th>System Unit</th>
				<th>Display</th>
				<th>Keyboard</th>
				<th>Mouse</th>
				<th>Action</th>
			</thead>
			<tbody>
			@if( count($workstations) == 0)
			@else
				@foreach($workstations as $workstation)
				<tr>
					<td>{{ $workstation->name }}</td>
					@if( count($workstation->systemunit) > 0 )
					<td>{{ $workstation->systemunit->property_number }}</td>
					@endif
					@if( count($workstation->systemunit) > 0 )
					<td>{{ $workstation->display->property_number }}</td>
					@endif
					<td>
					@if ($workstation->keyboard == 1 )
					yes
					@else
					no
					@endif 
					</td>
					<td>
					@if ($workstation->mouse == 1 )
					yes
					@else
					no
					@endif
					</td>
					<td>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('workstation.show',$workstation->id)]) }}	
						{{ Form::submit('Show',[
							'class'=>'btn btn-sm btn-primary btn-block pull-left col-sm-4'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-left">
						{{ Form::open(['method'=>'get','route' => array('workstation.edit',$workstation->id)]) }}	
						{{ Form::submit('Update',[
							'class'=>'btn btn-sm btn-info btn-block pull-left col-md-4'
						]) }}
						{{ Form::close() }}
						</div>
						<div class="pull-right">
						{{ Form::open(['method'=>'delete','route' => array('workstation.destroy',$workstation->id),'id'=>'deletionForm']) }}
							{{ Form::button('Condemn',[
								'class'=>'btn btn-sm btn-warning btn-block pull-right col-md-4 delete'
							]) }}
						{{ Form::close() }}
						</div>
					</td>
				</tr>
				@endforeach
			@endif
			</tbody>
		</table>
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

	$(document).ready(function() {
	    $('#workstationTable').DataTable();
	} );

  $('.delete').click(function(){
    swal({
      title: "Are you sure?",
      text: "This process is irreversible, do you want to continue?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, i want to continue!",
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        $("#deletionForm").submit();
      } else {
        swal("Cancelled", "Deletion Cancelled", "error");
      }
    });
  });
</script>
@stop