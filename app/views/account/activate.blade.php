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
  .panel-shadow{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body" hidden>
	@include('account.sidebar.default')
		<div class="col-md-7" id="account-info">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#activate" aria-controls="home" role="tab" data-toggle="tab">Activate</a></li>
			<li role="presentation"><a href="#deactivate" aria-controls="profile" role="tab" data-toggle="tab">Deactivate</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active panel-shadow" id="activate" style="background-color: white;">
				<div class="center-block" style="padding: 10px;">
					@if(count($user) > 0)
					<table class="table table-striped">
						<tbody>
						@foreach($user as $person)
							<tr>
								<td>
									@if($person->accesslevel == 0) "Administrator" 
									@elseif($person->accesslevel == 1) "Laboratory Assistant" 
									@elseif($person->accesslevel == 2) "Laboratory Staff" 
									@elseif($person->accesslevel == 3) "Faculty" 
									@elseif($person->accesslevel == 4) "Student"
									@endif
								</td>
								<td>{{ $person->firstname }} {{ $person->middlename }} {{ $person->lastname }}</td>
								<td>{{ Carbon\Carbon::parse($person->created_at)->toFormattedDateString() }}</td>
								<td>
									<button type="button" role="button" class="activate btn btn-sm btn-info pull-right"  id="{{ $person->id }}">Activate</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					@else
					<h5 class='text-center text-muted'>Yey! All Accounts are already activated</h5>
					@endif
				</div>
			</div>
			<div role="tabpanel" class="tab-pane panel-shadow" id="deactivate" style="background-color:white;">
				<div class="center-block" style="padding: 10px;">
					@if(count($user) > 0)
					<table class="table table-striped">
						<tbody>
						@foreach($user as $person)
							<tr>
								<td>
									@if($person->accesslevel == 0) "Administrator" 
									@elseif($person->accesslevel == 1) "Laboratory Assistant" 
									@elseif($person->accesslevel == 2) "Laboratory Staff" 
									@elseif($person->accesslevel == 3) "Faculty" 
									@elseif($person->accesslevel == 4) "Student"
									@endif
								</td>
								<td>{{ $person->firstname }} {{ $person->middlename }} {{ $person->lastname }}</td>
								<td>{{ Carbon\Carbon::parse($person->created_at)->toFormattedDateString() }}</td>
								<td>
									<button type="button" role="button" class="activate btn btn-sm btn-info pull-right"  id="{{ $person->id }}">Activate</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					@else
					<h5 class='text-center text-muted'>Yey! All Accounts are already deactivated</h5>
					@endif
				</div></div>
			<div role="tabpanel" class="tab-pane" id="messages"></div>
			<div role="tabpanel" class="tab-pane" id="settings">...</div>
		</div>
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
					Accounts under this list are inactive, blocked, or disabled due to some reasons. <span class="text-danger">Be cautious when activating an account</span>
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
		$('.activate').click(function(event){
			swal({
			  title: "Are you sure?",
			  text: "This account will be activated!",
			  type: "info",
			  showCancelButton: true,
			  // confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, activate it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
	      function(isConfirm){
	        if(isConfirm){
	          $.ajax({
	            type: 'post',
	            url: '{{ url('/activateAccount') }}',
	            data: {'id' : event.target.id },
	            before: function(){
					swal("Sending Data...");
	            }, 
	            success: function(response){ 
	            	window.location.reload();
	            },
	            error: function(response){
					swal("Error","Error encountered while activating the account","error");
	            }
	          });
	        } else{
	          swal("Cancelled","Operation Cancelled","error")
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
