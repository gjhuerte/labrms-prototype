@extends('layouts.master-white')
@section('title')
Faculty
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
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
  @include('faculty.sidebar.default')
	<div class="col-md-10" id="account-info">
		<div class="col-sm-12 panel panel-body panel-shadow table-responsive">
			<table id='userTable' class="table table-hover table-striped table-condensed table-bordered">
				<thead>
					<th>Username</th>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Last Update</th>
					<th class="no-sort"> </th>
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
						<td>
						@if(!empty($person->updated_at))
							{{ Carbon\Carbon::parse($person->updated_at)->toFormattedDateString() }}
						@else
							No Record
						@endif
						</td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('faculty.edit',$person->id)]) }}
							<button class="btn btn-sm btn-info btn-block" name="update" type="submit" value="Update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <span class="hidden-xs">Update</span></button>
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
