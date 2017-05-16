@extends('layouts.master-white')
@section('title')
Restore
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
	@include('account.sidebar.default')
	<div class="col-md-10" id="account-info">
		<div class="col-sm-12 panel panel-body panel-shadow table-responsive">
			<table id='userTable' class="table table-hover table-striped table-bordered table-condensed">
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
					@forelse($user as $person)
					<tr>
						<td>{{ $person->lastname }}</td>
						<td>{{ $person->firstname }}</td>
						<td>{{ $person->middlename }}</td>
						<td>{{ $person->email }}</td>
						<td>{{ $person->contactnumber }}</td>
						<td>{{ $person->type }}</td>
						<td>
							{{ Form::open(['method'=>'delete','route' => array('account.restore',$person->id),'id'=>'restoreForm']) }}
								<button class="btn btn-sm btn-info restore pull-right btn-block" type="button"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Restore</button>
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

		$('.restore').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "This account will be restored!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, restore it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
					$("#restoreForm").submit();
			  } else {
			    swal("Cancelled", "Restoration Cancelled", "error");
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
		$('#page-body').show();
	} );
</script>
@stop
