@extends('layouts.master-white')
@section('title')
Equipment Support
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ url('css/style.css') }}"  />
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  @include('equipment.support.sidebar.default')
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body panel-shadow  table-responsive">
				<table class="table table-hover table-striped table-bordered" id="equipmentSupportTable">
					<thead>
						<th>ID</th>
						<th>Type</th>
						<th>Problem Suggested / Category</th>
						<th>Created At</th>
						<th>Updated At</th>
					</thead>
				</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    $('#equipmentSupportTable').DataTable( {
				"processing": true,
        ajax: "{{ url('get/equipment/support/all') }}",
        columns: [
            { data: "id" },
            { data: "type" },
            { data: "problem" },
            { data: "updated_at" },
            { data: "created_at" },
        ],
    } );

		$('#page-body').show();

  });
</script>
@stop
