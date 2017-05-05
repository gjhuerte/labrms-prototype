@extends('layouts.master-blue')
@section('title')
Room Inventory
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.hideseek.min.js')) }}
@stop
@section('style')
<style>
	#page-body{
		display: none;
	}
	.panel{
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class="col-md-2">
    <div class="panel panel-body">
        <div>
					<button class="btn btn-default btn-block" id="assign">Assign</button>
					<table class="table table-hover" >
						<thead>
							<th>Rooms</th>
						</thead>
						<tbody>
							@foreach($rooms as $room)
							<tr>
								<td class="text-muted" >{{ $room->name }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
    </div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function() {

		$('#assign').click(function(){
				window.location.href = "{{ url('inventory/room/assign') }}";
		});

		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
		$('#page-body').show();
	} );
</script>
@stop
