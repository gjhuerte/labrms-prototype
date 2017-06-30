@extends('layouts.master-blue')
@section('title')
Tickets
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<style>
	#page-body{
		display: none;
	}
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
@include('modal.ticket.create')
	<div class="panel col-sm-offset-3 col-sm-6">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<p class="text-muted">
						Instructions 
					</p>
					<p class="text-success">
						*Generate button will display the form to generate a ticket 
					</p>
					<p class="text-warning">
						*You can choose if you want to display your own ticket or list of all tickets. <strong>Note: </strong>Displaying the list of all tickets will take longer to load 
					</p>
					<p class="text-danger">
						*Different ticket type will result to a different action
					</p>
				</div>
				<div class="col-md-12" style="margin: 10px 0px;">
					<div class="btn-group">
						<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#generateTicketModal">
							<span class="glyphicon glyphicon-plus">
							</span>
							Generate
						</button>
					</div>
					<div class="btn-group pull-right">
						<div class="btn-group" style="margin: 0 10px;">
							<select class="form-control">
								<option>Receive</option>
								<option>Complaints</option>
								<option>Incident</option>
								<option>Maintenance</option>
							</select>
						</div>
						<div class="btn-group">
							<button class="btn btn-primary" id="own">Own</button>
						</div>
						<div class="btn-group">
							<button class="btn btn-default" id="all">All</button>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<!-- List group -->
					<ul class="list-group">
						<li class="list-group-item">
							Cras justo odio
							<button class="btn btn-info btn-xs pull-right">Resolve</button>
						</li>
						<li class="list-group-item">Dapibus ac facilisis in</li>
						<li class="list-group-item">Morbi leo risus</li>
						<li class="list-group-item">Porta ac consectetur ac</li>
						<li class="list-group-item">Vestibulum at eros</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	$(document).ready(function(){

		$('#own').click(function(){
			changeClass('#own','#all')
		})

		$('#all').click(function(){
			changeClass('#all','#own')
		})

		$('#page-body').show();

		function changeClass(obj1, obj2)
		{
			$(obj1).removeClass('btn-default')
			$(obj2).removeClass('btn-primary')
			$(obj1).addClass('btn-primary')
			$(obj2).addClass('btn-default')
		}
	})
</script>
@stop