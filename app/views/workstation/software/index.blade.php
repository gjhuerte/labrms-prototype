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
						<th>ID</th>
            <th>Operating System Key</th>
						<th>Software Installed</th>
						<th>Location</th>
						<th class="no-sort"></th>
					</thead>
					<tbody>
						@forelse($workstation as $workstation)
						<tr>
								<td>{{ $workstation->id }}</td>
								<td>{{ $workstation->oskey }}</td>
								<td><a data-id="{{ $workstation->id }}">View Software Installed</a></td>
								<td><a data-id="{{ $workstation->id }}">View Location Deployed</a></td>
								<td>
									{{ Form::open() }}
									<button class="btn btn-info">
										<span class="glyphicon glyphicon-eye-open"></span> <span>View</span>
									</button>
									<button class="btn btn-primary">
										<span class="glyphicon glyphicon-share-alt"></span> <span>Deploy</span></button>
									<button class="btn btn-default">
										<span class="glyphicon glyphicon-plus"></span> <span>Assign Software</span></button>
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
