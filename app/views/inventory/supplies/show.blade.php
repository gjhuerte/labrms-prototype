@extends('layouts.master-blue')
@section('title')
Supply History
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<legend><h3 class="text-muted">Supply History</h3></legend>
				<ul class="breadcrumb">
					<li><a href="{{ url('supplies') }}">Supply</a></li>
					<li class="active">{{ $supply->itemtype->name }}</li>
					<li class="active">{{ $supply->brand }}</li>
				</ul>
				<div class="table-responsive">
					<table class="table table-hover" id="supplyHistoryTable">
						<thead>
							<th>Date</th>
							<th>Quantity</th>
							<th>Remark</th>
							<th>Accessor</th>
						</thead>
						<tbody>
							@forelse($supplyhistory as $supplyhistory)
							<tr>
								<td>{{ Carbon\Carbon::parse($supplyhistory->created_at)->toFormattedDateString() }}</td>
								<td>{{ $supplyhistory->quantity }}</td>
								<td>{{ $supplyhistory->remark }}</td>
								<td>{{ $supplyhistory->personinvolve }}</td>								
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$('#supplyHistoryTable').DataTable();
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
