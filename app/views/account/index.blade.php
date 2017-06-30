@extends('layouts.master-blue')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('account.sidebar.default')
	<div class="col-md-12" id="account-info">
		<div class="col-sm-12 panel panel-body  table-responsive">
			<table id='userTable' class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Type</th>
					<th>Priviledge</th>
					<th>Status</th>
				</thead>
				<tbody>
						@forelse($user as $person)
						<tr>
							<td>{{ $person->lastname }}</td>
							<td>{{ $person->firstname }}</td>
							<td>{{ $person->middlename }}</td>
							<td>{{ $person->email }}</td>
							<td>{{ $person->contactnumber }}</td>
							<td>{{ $person->type }}</td>
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
          @empty
          @endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
    $('#userTable').DataTable();
		$('#page-body').show();
	} );
</script>
@stop
