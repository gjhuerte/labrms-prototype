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
	@include('account.sidebar.overview')
	<div class="col-sm-10" id="account-info">
		<div class="col-sm-12 panel panel-body table-responsive">
			<table id='userTable' class="table table-hover table-striped table-condensed">
				<thead>
					<th>Lastname</th>
					<th>Firstname</th>
					<th>Middlename</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Type</th>
					<th>Action</th>
				</thead>
				<tbody>
					@foreach($user as $person) 
					<tr>
						<td>{{ $person->lastname }}</td>
						<td>{{ $person->firstname }}</td>
						<td>{{ $person->middlename }}</td>
						<td>{{ $person->email }}</td>
						<td>{{ $person->contactnumber }}</td>
						<td>{{ $person->type }}</td>
						<td>
							{{ Form::open(['method'=>'get','route' => array('account.show',$person->id)]) }}
							<button class="btn btn-sm btn-primary col-sm-4 pull-left" name="view" type="submit" value="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
							{{ Form::close() }}
							{{ Form::open(['method'=>'get','route' => array('account.edit',$person->id)]) }}
							<button class="btn btn-sm btn-info col-sm-4 pull-left" name="update" type="submit" value="Update"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							{{ Form::close() }}
							{{ Form::open(['method'=>'delete','route' => array('account.destroy',$person->id),'id'=>'deletionForm']) }}	
							<button class="btn btn-sm btn-warning col-sm-4 delete pull-right" name="delete" type="cancelButtonText" value="Condemn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
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
		$('#page-body').show(400);

		$('button.delete').on("click",function(){
			swal({
			  title: "Are you sure?",
			  text: "You will not be able to recover this account!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, delete it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
					$("#deleteForm").submit();
			  } else {
			    swal("Cancelled", "Deletion Cancelled", "error");
			  }
			});
		});

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
