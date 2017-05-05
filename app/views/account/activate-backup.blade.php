@extends('layouts.master-white')
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
<style>
  .panel{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('account.sidebar.default')
	<div class="col-md-7" id="account-info">
		@foreach($user as $person)
		<div class="panel panel-default">
			<div class="panel-body" style='letter-spacing: 2px;'>
				<div class="col-md-4">
					<img src="{{ asset('images/profile/blank-profile-picture-logo.png') }}" alt="Profile Picture" class="img-rounded" style="height: 128px;width: 128px;">
				</div>
				<div class="col-md-6">
					<input type="hidden" id="id" value="{{ $person->id}}">
					<h4 class="text-primary"><strong>{{ $person->firstname }} {{ $person->middlename }} {{ $person->lastname }}</strong></h4>
					<p><span class="text-muted">Role: </span><span class="text-success"> 
					@if($person->accesslevel == 0) "Administrator" 
					@elseif($person->accesslevel == 1) "Laboratory Assistant" 
					@elseif($person->accesslevel == 2) "Laboratory Staff" 
					@elseif($person->accesslevel == 3) "Faculty" 
					@elseif($person->accesslevel == 4) "Student"
					@endif</span></p>
					<p><span class="text-muted">Created At: </span><span class="text-success">{{ Carbon\Carbon::parse($person->created_at)->toFormattedDateString() }}</span></p>
				</div>
				<div class="col-md-2">
				{{ Form::button('Activate',[
					'class'=>'activate btn btn-md btn-primary pull-right'
				]) }}
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		@endforeach
	</div>
	<div class="col-md-3">
		<div class="panel panel-primary" style="border: none;border-radius: 0px;">
			<div class="panel-heading">
				Important Notes
			</div>
			<div class="panel-body">
				<dl>
				<dt class="bg-info text-info" style="padding: 10px;margin: 10px;"> Accounts Under This List:
				</dt>
				<dd class="text-muted" style="padding: 10px;margin: 10px;">
					Accounts under this list are inactive, blocked, or disabled due to some reasons. 
				</dd>
				</dl>
			</div>
		</div>
	</div>
  </div>
</div>
@stop
@section('script')
<script>
	$(document).ready(function() {
		$('#page-body').show();

		$('.activate').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "This account will be activated!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, activate it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
			  	alert("ID:"+$('#id').val());
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
	    $('#userTable').DataTable();
	} );
</script>
@stop
