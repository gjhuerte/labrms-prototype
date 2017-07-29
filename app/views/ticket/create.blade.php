@extends('layouts.master-blue')
@section('title')
Ticket | Create
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
{{ HTML::style('css/jquery-ui.min.css') }}
<style>

	#page-body,.transfer, .action-taken{
		display:none;
	}

	.panel-padding{
		padding: 25px;
	}

	.panel{
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
</style>
<div class="container-fluid" id="page-body" style="margin-top: 40px;">
	<div class='col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6'>  
		<div class="panel panel-body panel-padding">
			<legend><h3 style="color:#337ab7;">Generate Ticket</h3></legend>
			<ul class="breadcrumb">
				<li>
					<a href="{{ url('ticket') }}">Ticket</a>
				</li>
				<li>
					Create
				</li>
			</ul>
		      @if (count($errors) > 0)
		          <div class="alert alert-danger alert-dismissible" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		              <ul style='margin-left: 10px;'>
		                  @foreach ($errors->all() as $error)
		                      <li>{{ $error }}</li>
		                  @endforeach
		              </ul>
		          </div>
		      @endif    
			{{ Form::open(['method'=>'post','route'=>'ticket.store','class'=>'form-horizontal','id'=>'ticketForm']) }}
				<div class="form-group">
					<div class="col-sm-12">
						{{ Form::label('Ticket Number: '.$lastticket) }}
					</div>
				</div>
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('propertynumber','Equipment Property Number') }}
					{{ Form::text('propertynumber',Input::old('propertynumber'),[
						'id' => 'propertynumber',
						'class' => 'form-control'
					]) }}
					</div>
				</div>
				<div class="alert alert-info" id="propertynumber-details" hidden>
				</div>
				<!-- Item name -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Ticket Type') }}
					<select class="form-control" name="type" id="type">
						<option value="maintenance">Maintenance</option>
						<option value="complaint">Complaints</option>
					</select>
					</div>
				</div>
				<!-- Item name -->
				<div class="form-group maintenance" id="maintenance-type">
					<div class="col-sm-12">
					{{ Form::label('maintenancetype','Maintenance Type') }}
					<select class="form-control" name="maintenancetype" id="maintenancetype">
						<option value="preventive"> Preventive </option>
						<option value="corrective"> Corrective </option>
					</select>
					</div>
				</div>

				<div class="form-group maintenance">
					<div class="col-sm-12">
						{{ Form::label('category','Category') }}
						<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="You need to clarify the category/repairs you've done to the item" tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
						<select class="form-control" name="category" id="category">
							<option> None </option>
						</select>
					</div>
				</div>

				<div class="form-group" id="author-form">
					<div class="col-sm-12">
						{{ Form::label('author','Author') }}
						<span type="button" id="inventory-help" class="btn-link glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="popover" title="Help" data-content="The ticket author is the person who request for this ticket to be generated. If the ticket has no author, you can leave this field blank" tabindex="0" data-trigger="focus" style="text-decoration: none;"></span>
						{{ Form::text('author',Input::old('author'),[
						'class'=>'form-control'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<!-- description -->
					<div class="col-sm-12">
						{{ Form::label('description','Details') }}
						{{ Form::textarea('description',Input::old('description'),[
							'class'=>'form-control',
							'placeholder'=>'Enter ticket details here...'
						]) }}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::submit('Create',[
						'class'=>'btn btn-lg btn-block btn-md btn-primary'
					]) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('script')
{{ HTML::script(asset('js/loadingoverlay.min.js')) }}
{{ HTML::script(asset('js/jquery-ui.js')) }}
{{ HTML::script(asset('js/loadingoverlay_progress.min.js')) }}
<script>
	$(document).ready(function(){
		$( "#propertynumber" ).autocomplete({
		  source: "{{ url('get/propertynumber/all') }}"
		});

		$('#propertynumber').on('change',function(){
			try{
				$.ajax({
					type: 'get',
					url: '{{ url("get") }}' + '/' + $('#propertynumber').val() + '/status',
					dataType: 'json',
					success: function(response){
						try{
							if(response == 'error') {
								console.log(response)
								$('#propertynumber-details').hide()
								$('#propertynumber-details').html("")
							} else {
								console.log(response)
								$('#propertynumber-details').show()
								list = "<ul class='list-unstyled'>";
								list += `<li> Brand:` + response.inventory.brand + `</li>`
								list += `<li> Model:` + response.inventory.model + `</li>`
								list += `<li> Type:` + response.inventory.itemtype.name + `</li>`
								list += "</ul>"
								console.log(list)
								$('#propertynumber-details').html("")
								$('#propertynumber-details').append(list)
							}
						}catch (e) {
								$('#propertynumber-details').hide()
						}
					}				
				})
			} catch (e) {}
		});

		setCategory()

		$('#maintenancetype').on("change",function(){
			setCategory();
		})

		$('#type').change(function(){
			var type = $('#type').val();
			if(type == 'maintenance')
			{
				$('#author-form > .col-sm-12 > label').text('Author')
				$('.maintenance').show(400);
			}else{
				$('#author-form > .col-sm-12 > label').text('Complainant')
				$('.maintenance').hide(400);
			}
		});

		function setCategory()
		{
			var type = $('#maintenancetype').val();
			$.ajax({
				type: 'get',
				url: '{{ url("get/equipment/support") }}' + '/' + type,
				dataType: 'json',
				success: function(response){
			    options = "";
			    if(response.length == 0)
			    {
			      options = "<option>Empty list</option>";

			    }else{
				    for(var ctr = 0;ctr<response.length;ctr++){
				      		options += "<option value="+response[ctr].problem+">"+response[ctr].problem+"</option>";
				    }
					}

			    $('#category').html(" ");
			    $('#category').append(options);
				}
			});
		}

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif


		$('#page-body').show();
	})
</script>
@stop