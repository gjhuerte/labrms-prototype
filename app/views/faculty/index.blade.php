@extends('layouts.master-blue')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style-include')
  {{ HTML::style(asset('css/bootstrap-toggle.min.css')) }}
@stop
@section('script-include')
  {{ HTML::script(asset('js/bootstrap-toggle.min.js')) }}
@stop
@section('style')
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('faculty.sidebar.default')
	<div class="col-md-10" id="account-info">
		<div class="col-sm-12 panel panel-body table-responsive">
			<table id='userTable' class="table table-hover table-striped table-condensed">
				<thead>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>College</th>
					<th>Subject</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach($user as $person) 
					<tr>
						<td>{{ $person->lastname }}</td>
						<td>{{ $person->firstname }}</td>
						<td>{{ $person->middlename }}</td>
						<td>{{ $person->email }}</td>
						<td>{{ $person->contactnumber }}</td>
						<td>
						@if( $person->accesslevel == 0) Laboratory Head
						@elseif( $person->accesslevel == 1) Laboratory Assistant
						@elseif( $person->accesslevel == 2) Laboratory Staff
						@elseif( $person->accesslevel == 3) Faculty
						@elseif( $person->accesslevel == 4) Student
						@endif
						</td>
						<td class="{{ ($person->status == 1) ? 'text-success' : 'text-danger'; }}">
							{{ ($person->status == 1) ? 'Active' : 'Inactive'; }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$(document).ready(function() {
		$('#page-body').show();

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	    $('#userTable').DataTable();
	} );
</script>
@stop
