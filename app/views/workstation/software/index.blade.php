@extends('layouts.master-blue')
@section('title')
Workstation
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

	a:hover{
	  	text-decoration: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('workstation.sidebar.default')
	<div class="col-md-12" id="workstation-info">
		<div class="panel panel-body  table-responsive">
				<table class="table table-hover table-striped table-bordered" id="workstationTable">
					<thead>
						<th>ID</th>
      			<th>Operating System Key</th>
						<th>Software Installed</th>
						<th class="no-sort"></th>
					</thead>
					<tbody>
						@forelse($workstation as $workstation)
						<tr>
								<td class="col-sm-1">{{ $workstation->id }}</td>
								<td class="col-sm-4">{{ $workstation->oskey }}</td>
								<td class="col-sm-5"><a role="button" class="text-primary link" data-id="{{ $workstation->id }}">View Software Installed</a></td>
								<td class="col-sm-2">
									<div class="btn-group btn-group-justified">
										<div class="btn-group">
											<a type="button" class="btn btn-default" href="{{ url("workstation/software/$workstation->id/assign") }}">
												<span class="glyphicon glyphicon-plus"></span> <span>Assign</span>
											</a>
										</div>
										<div class="btn-group">
											<a type="button" class="btn btn-danger" href="{{ url("workstation/software/$workstation->id/remove") }}">
												<span class="glyphicon glyphicon-trash"></span> <span>Remove</span>
											</a>
										</div>
									</div>
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
<script type="text/javascript">

	$(document).ready(function() {

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

    	$('#workstationTable').DataTable({
			columnDefs:[
			{ targets: 'no-sort', orderable: false },
			],
		});

		$('.link').on('click',function(){
			var id = $(this).data('id');
			object = $(this);
			if($(this).html() != 'View Software Installed')
			{}
			$.ajax({
				type: 'get',
				url: '{{ url("get/software/installed") }}' + '/' + id,
				dataType: 'json',
				beforeSend: function(){
					swal('Requesting for information...','Please wait for a moment while softwares are being loaded','info');
				},
				success: function(response){
					html = '<ul class="text-muted list-unstyled">';
					for(ctr= 0; ctr < response.length;ctr++){
						html += `<li>`+response[ctr].softwarename+` - `+response[ctr].key+`</li>`;
					}

					html += '</ul>';

					if(response.length == 0){
						html = "<ul class='text-muted list-unstyled'><li>None</li></ul>";
					}

					object.html(html);
				},
				complete: function(){
					swal('Information Loaded','The information you require has been loaded to the table','success')
				}
			});
		});

		$('#page-body').show();
  });
</script>
@stop
