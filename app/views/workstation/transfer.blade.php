@extends('layouts.master-blue')
@section('title')
Transfer
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
{{ HTML::style('css/jquery.bootgrid.min.css') }}
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
  #page-body{
    display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
	@include('workstation.sidebar.default')
	<div class="col-md-12">
	  <div class="col-sm-12 panel panel-body" >
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
      {{ Form::open(array('method'=>'post','route'=>'workstation.transfer','id'=>'deploymentForm')) }}
	    <div class = 'form-horizontal'>
        <div class="form-inline">
        {{ Form::select('room',['Loading all rooms ...'],Input::old('room'),[
            'id' => 'room',
            'class' => 'form-control'
          ]) }}
          <button class="btn btn-success btn-flat" id="deploy" name="create" type="button" style="padding: 5px"><span class="glyphicon glyphicon-share"></span> Transfer to</button>
          <input type="hidden" value="0" id="pc" name="pc"/>
        </div>
        <hr />
        <table class="table table-hover table-striped table-bordered" id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
            <thead>
                <tr>
                    <th data-column-id="id" data-identifier="true" data-type="numeric">ID</th>
                    <th data-column-id="sender" data-order="asc">System Unit</th>
                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Monitor</th>
                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">AVR</th>
                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Keyboard</th>
                    <th data-column-id="mouse" data-visible="true" data-visible-in-selection="false">Mouse</th>
                    <th data-column-id="location" data-visible="true" data-visible-in-selection="false">Location</th>
                </tr>
            </thead>
            <tbody id="grid-body"></tbody>
        </table>
	    </div>
	    {{ Form::close() }}
	  </div>
	</div>
</div><!-- Container -->
@stop
@section('script')
{{ HTML::script(asset('js/jquery.bootgrid.min.js')) }}
{{ HTML::script(asset('js/jquery.bootgrid.fa.min.js')) }}
<script>
  $(document).ready(function(){

    init();

    function init()
    {

      $('#grid-body').html('');

      $.ajax({
        type: 'get',
        url: "{{ url('get/workstation/tableform/all/location') }}",
        dataType: 'html',
        success: function(response){
          $('#grid-body').append(response);
        },
        complete: function(){
          $("#grid").bootgrid({
              formatters: {
                  "link": function(column, row)
                  {
                      return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                  }
              },
              rowCount: [-1, 10, 50, 75]
          });
        }
      });

      $.ajax({
  			type : "get",
  			url : "{{ route('room.index') }}",
  			dataType : "json",
  			success : function(response){
  				options = "";
  				for(ctr = 0;ctr<response.length;ctr++){
  					options += `<option value='`+response[ctr].name+`'>`+response[ctr].name+`</option>'`;
  				}

  				$('#room').html("");
  				$('#room').append(options);
  				@if(Input::old('room'))
  				$('#room').val({{ "'".Input::old('room')."'" }});
  				@else
  				$('#room').val('Server');
  				@endif
  			},
  			error : function(response){
  				$('#location').html("<option>Loading all room ...</option>")
  				console.log(response.responseJSON);
  			}
      })
    }

    $("#deploy").on("click", function ()
    {
      if($("#grid").bootgrid("getSelectedRows") == "" || $("#grid").bootgrid("getSelectedRows") == null)
      {
        swal('Error Ocurred','You need to atleast check a single number','error');
      }else{
        $('#pc').val($("#grid").bootgrid("getSelectedRows"));
        $('#deploymentForm').submit();
      }
    });

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('#page-body').show();

  });
</script>
@stop
