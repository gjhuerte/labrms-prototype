@extends('layouts.master-blue')
@section('title')
Workstation
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('workstation.sidebar.default')
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body  table-responsive">
				<table class="table table-hover table-striped table-bordered" id="workstationTable">
					<thead>
						<th>OS</th>
						<th>System Unit</th>
						<th>Monitor</th>
						<th>AVR</th>
						<th>Keyboard</th>
						<th>Mouse</th>
						<th class="no-sort"></th>
					</thead>
					<tbody>
					@forelse($workstations as $workstation)
					<tr>
						<td>{{ $workstation->oskey }}</td>
						<td>{{ $workstation->systemunit->propertynumber }}</td>
						<td>{{ $workstation->monitor->propertynumber }}</td>
						<td>{{ $workstation->avr->propertynumber }}</td>
						<td>{{ $workstation->keyboard->propertynumber }}</td>
						<td>
						@if ($workstation->mouse == 1 )
						yes
						@else
						no
						@endif
						</td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('workstation.edit',$workstation->id)]) }}
							{{ Form::submit('Update',[
								'class'=>'btn btn-sm btn-default btn-block'
							]) }}
							{{ Form::close() }}
						</td>
					</tr>
					@empty
					@endforelse
					</tbody>
				</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    $('#workstationTable').DataTable({
			columnDefs:[
			{ targets: 'no-sort', orderable: false },
			],
		});

		$('#page-body').show();
  });
</script>
@stop
