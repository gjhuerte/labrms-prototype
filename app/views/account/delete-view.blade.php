@extends('layouts.master-blue')
@section('title')
Accounts
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
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
					<th class="no-sort"> </th>
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

							{{ Form::open(['method'=>'delete','route' => array('account.destroy',$person->id),'id'=>'deletionForm']) }}
							<button type="button" class="btn btn-block btn-sm btn-danger delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</button>
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

		$('.delete').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "This account will be removed from your database!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, remove it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
			  	$('#deletionForm').submit();
			  } else {
			    swal("Cancelled", "Activation Cancelled", "error");
			  }
			});
		});

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
