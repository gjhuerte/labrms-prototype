@extends('layouts.master-blue')
@section('title')
Inventory | Import
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style(asset('css/style.css')) }}
{{ HTML::style(asset('css/jquery-ui.min.css')) }}
<style>
	#inventory,#page-body{
		display:none;
	}

	#podate,#invoicedate{
		background-color:white;
	}

</style>
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery-ui.js')) }}
@stop
@section('content')
<div class="container-fluid" id="page-body">
	<div class='col-md-offset-3 col-md-6'>
		<div class="panel panel-body">
	      @if (count($errors) > 0)
         	 <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <ul class="list-unstyled" style='margin-left: 10px;'>
	                  @foreach ($errors->all() as $error)
	                      <li class="text-capitalize">{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif
		<ul class="breadcrumb">
			<li><a href="{{ url('inventory/item') }}">Inventory</a></li>
			<li><a href="{{ url('inventory/item') }}">Item</a></li>
			<li class="active">Import</li>
		</ul>
      <div>
      	{{ Form::open(['method'=>'post','route'=>array('inventory.item.import'),'enctype'=>'multipart/form-data']) }}
      	<div class="form-group">
        {{ Form::file('file') }}
        </div>
        <div class="form-group">
        {{ Form::submit('Import',[
        	'class' => 'btn btn-primary btn-block pull-right'
        ]) }}
        </div>
        {{ Form::close() }}
      </div>
		</div>
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){

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
