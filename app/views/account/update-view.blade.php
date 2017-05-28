@extends('layouts.master-white')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
  #page-body{
  	display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('account.sidebar.default')
	<div class="col-md-12" id="account-info">
		<div class="col-sm-12 panel panel-body panel-shadow table-responsive">
			<table id='userTable' class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<th>Username</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Type</th>
					<th>Last Update</th>
					<th class="no-sort"> </th>
				</thead>
				<tbody>
					@forelse($user as $person)
					<tr>
						<td>{{ $person->username }}</td>
						<td>{{ $person->lastname }}</td>
						<td>{{ $person->firstname }}</td>
						<td>{{ $person->middlename }}</td>
						<td>{{ $person->email }}</td>
						<td>{{ $person->contactnumber }}</td>
						<td>{{ $person->type }}</td>
						<td>
						@if(!empty($person->updated_at))
							{{ Carbon\Carbon::parse($person->updated_at)->toFormattedDateString() }}
						@else
							No Record
						@endif
						</td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('account.edit',$person->id)]) }}
							<button class="btn btn-sm btn-info btn-block" name="update" type="submit" value="Update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <span class="hidden-xs">Update</span></button>
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
<script>
	$(document).ready(function() {
		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
	    $('#userTable').DataTable({
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
	    });
		$('#page-body').show();

	} );
</script>
@stop
