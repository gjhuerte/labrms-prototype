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
	@include('inventory.sidebar.default')

	<div class="col-md-offset-1 col-md-8">
        <div class="panel panel-body">
        	<div class="col-md-offset-8 col-md-4">
            	<input id="search-highlight" name="search-highlight" placeholder="Room Name or Description" type="text" data-list=".highlight_list" autocomplete="off" class="form-control">
        	</div>
            <div style="margin-top: 20px;">
				<table class="table table-hover  table-striped" >
					<thead>
						<th>Name</th>
						<th>Description</th>
					</thead>
					<tbody class="highlight_list">
						@foreach($rooms as $room)
						<tr>
							<td class="text-muted">{{ $room->name }}</td>
							<td class="text-muted">{{ $room->description }}</td>
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
		$('#page-body').show();
		@if( Session::has("success-message") )
			swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
			swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif
		$('#roomTable').DataTable();
		$('#search-highlight').hideseek({
			highlight: true,
			hidden_mode: true,
		});
	} );
</script>
@stop
