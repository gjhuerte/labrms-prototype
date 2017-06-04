@extends('layouts.master-blue')
@section('title')
Software list
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
	@include('software.sidebar.default')
	<div class="col-md-12" id="room-info">
		<div class="panel panel-body  table-responsive">
			<table class="table table-hover table-striped table-bordered" id='softwareTable'>
				<thead>
					<th>Software name</th>
					<th>License type</th>
					<th>Software type</th>
					<th>Minimum Requirements</th>
					<th>Maximum Requirements</th>
					<th class="no-sort"></th>
				</thead>
				<tbody>
				@if( count($softwares) == 0)
				@else
					@foreach( $softwares as $software )
					<tr>
						<td>
						 <span class="truncate">{{{ $software->softwarename }}}</span>
						 @if(isset($software->softwarename) && strlen($software->softwarename) > 20 )
						 <a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $software->softwarename }}}">more</a>
						 @endif
					 </td>
					 <td>
						 <span class="truncate">{{{ $software->licensetype }}}</span>
						 @if(isset($software->licensetype) && strlen($software->licensetype) > 20 )
						 <a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $software->licensetype }}}">more</a>
						 @endif
					 </td>
					 <td>
						 <span class="truncate">{{{ $software->softwaretype }}}</span>
						 @if(isset($software->softwaretype) && strlen($software->softwaretype) > 20 )
						 <a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $software->softwaretype }}}">more</a>
						 @endif
					 </td>
						<td>
							<span class="truncate">{{{ $software->minsysreq }}}</span>
							@if(isset($software->minsysreq) && strlen($software->minsysreq) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $software->minsysreq }}}">more</a>
							@endif
						</td>
						<td>
							<span class="truncate">{{{ $software->maxsysreq }}}</span>
							@if(isset($software->maxsysreq) && strlen($software->maxsysreq) > 20 )
							<a tabindex="0" class="btn btn-link" role="button" data-toggle="popover" data-trigger="focus" data-content="{{{ $software->maxsysreq }}}">more</a>
							@endif
						</td>
						<td>
							{{ Form::open(['method'=>'delete','route' => array('software.destroy',$software->id),'id'=>'deletionForm']) }}
							<button type="button" class="btn btn-block btn-sm btn-danger delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</button>
							{{ Form::close() }}
						</td>
					</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#softwareTable').dataTable({
	    	columnDefs:[
				{ targets: 'no-sort', orderable: false },
	    	],
    });

    $('[data-toggle="popover"]').popover();

		@if( Session::has("success-message") )
		swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('.delete').click(function(){
			swal({
				title: "Are you sure?",
				text: "This process is irreversible, do you want to continue?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, i want to continue!",
				cancelButtonText: "No, cancel it!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm){
				if (isConfirm) {
					$("#deletionForm").submit();
				} else {
					swal("Cancelled", "Deletion Cancelled", "error");
				}
			});
		});

    $('.truncate').succinct({
        size: 20
    });

		$('#page-body').show();
	});
</script>
@stop
