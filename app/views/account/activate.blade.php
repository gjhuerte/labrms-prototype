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

  #page-body{
  	display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('account.sidebar.default')
	<div class="col-md-7" id="account-info">
		<div class="panel panel-body panel-shadow">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#activate" aria-controls="home" role="tab" data-toggle="tab" id="activate_button">Activate</a></li>
				<li role="presentation"><a href="#deactivate" aria-controls="profile" role="tab" data-toggle="tab" id="deactivate_button">Deactivate</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="activate">
					<div class="center-block" style="padding: 10px;">
						<table class="table table-bordered" id="activateTable">
							<thead>
								<th>Access level</th>
								<th>Name</th>
								<th>Created At</th>
								<th></th>
							</thead>
							<tbody>
							@if(count($user) > 0)
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
										<button type="button" role="button" class="activate btn btn-sm btn-primary btn-block btn-activate"  id="{{ $person->id }}"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> Activate</button>
									</td>
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="deactivate" style="background-color:white;">
					<div class="center-block" style="padding: 10px;">
						<table class="table table-bordered" id="deactivateTable">
							<thead>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</thead>
							<tbody>
							@if(count($user) > 0)
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
										<button type="button" role="button" class="activate btn btn-sm btn-danger btn-block"  id="{{ $person->id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Deactivate</button>
									</td>
								</tr>
								@endforeach
							</tbody>
							@endif
						</table>
					</div>
				</div>
			</div>
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

		$('#activate_button').click(function(){
			setTable(0,'Activate','btn-activate','activateTable','primary','activate','up')
		});

		$('#deactivate_button').click(function(){
			setTable(1,'Deactivate','btn-deactivate','deactivateTable','danger','deactivate','down');
		});

		function setTable(status,type,classname,tablename,buttontype,panel,arrow){

			$.ajax({
				type: 'get',
				url: "{{ url('/account/view/activation') }}",
				data: {'status' : status},
				dataType: 'json',
				success: function(response){
					options = "";
				    for(var ctr = 0;ctr<response.length;ctr++){
							access = "Student";
							if(response[ctr].accesslevel == 0) access  = "Administrator";
							else
								if(response[ctr].accesslevel == 1) access  =  "Laboratory Assistant" ;
							else
								if(response[ctr].accesslevel == 2) access  =  "Laboratory Staff";
							else
								if(response[ctr].accesslevel == 3) access  =  "Faculty" ;
							else
								if(response[ctr].accesslevel == 4) access  =  "Student";

							options += `<tr>
								<td>
									`+access+`
								</td>
								<td>`+response[ctr].lastname+`, `+response[ctr].firstname+` `+response[ctr].middlename+`</td>
								<td>{{ Carbon\Carbon::parse(`+response[ctr].created_at+`)->toFormattedDateString() }}</td>
								<td>
									<button type="button" role="button" class="btn btn-sm btn-`+buttontype+` btn-block `+classname+`"  id="`+response[ctr].id+`"> <span class="glyphicon glyphicon-arrow-`+arrow+`" aria-hidden="true"></span> `+type+`</button>
								</td>
							</tr>`;
				    }
					$('#'+tablename + "> tbody").html("");
					if(response.length > 0){
						$('#'+tablename).append(options);
					}else{
						$('#'+tablename + " > tbody").html("<tr class='odd'><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>");
					}
				},
					error: function(response){
					console.log(response.responseJSON);
				}
			});
		}

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#deactivateTable').on('click','button.btn-deactivate',function(event){
			var id = event.target.id;
			$.ajax({
				type:'post',
				url:'{{ url("account/view/activation") }}',
				data: {
						'id' : id,
						'type' : 'deactivate'
					},
				dataType: 'json',
				success: function(response){
					setTable(1,'Deactivate','btn-deactivate','deactivateTable','danger','deactivate','down');
					swal('Account Deactivated','','success');
				},
					error: function(response){
					console.log(response.responseJSON);
				}

			});
		});

		$('#activateTable').on('click','button.btn-activate',function(event){
			var id = event.target.id;

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
						type:'post',
						url:'{{ url("account/view/activation") }}',
						data: {
								'id' : id,
								'type' : 'activate'
							},
						dataType: 'json',
						success: function(response){
							setTable(0,'Activate','btn-activate','activateTable','primary','activate','up');
							swal('Account Activated','','success');
						},
							error: function(response){
							console.log(response.responseJSON);
						}

					});
				} else{
					swal("Cancelled","Operation Cancelled","error")
				}
			});
		});

	    $('#activateTable').DataTable({
	  		fnDrawCallback: function() {
	  		$("#activateTable").removeAttr( 'style' );
		    $("#activateTable thead").remove();
		  }
	    });

	    $('#deactivateTable').DataTable({

	  		fnDrawCallback: function() {
	  		$("#deactivateTable").removeAttr( 'style' );
		    $("#deactivateTable thead").remove();
		  }
	    });

		$('#page-body').show();
	} );
</script>
@stop
