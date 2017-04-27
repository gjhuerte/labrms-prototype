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
					<th>Username</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Type</th>
					<th>Last Update</th>
					<th> </th>
				</thead>
				<tbody>
					@foreach($user as $person) 
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
							<button class="btn btn-sm btn-info" name="update" type="submit" value="Update">Update</button>
							{{ Form::close() }}
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
