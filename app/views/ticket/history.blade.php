@extends('layouts.master-blue')
@section('title')
Ticket | History
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
@section('script-include')
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="col-md-offset-3 col-md-6">
    <div class="panel panel-body ">
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
      <div class='col-md-12'>
          <ol class="breadcrumb">
              <li><a href="{{ url('ticket') }}">Ticket</a></li>
              <li>{{ $id }}</li>
              <li class="active">History</li>
          </ol>
          <legend class="text-muted">Information</legend>
          <div class="form-group">
            <label>Name</label>
            {{ Form::text('name',$ticket->ticketname,[
                'class' => 'form-control',
                'readonly',
                'style' => 'background-color: white;'
              ]) }}
          </div>
          <div class="form-group">
            <label>Type</label>
            {{ Form::text('type',$ticket->tickettype,[
                'class' => 'form-control',
                'readonly',
                'style' => 'background-color: white;'
              ]) }}
          </div>
          <div class="form-group">
            <label>Details</label>
            {{ Form::textarea('details',$ticket->details,[
                'class' => 'form-control',
                'readonly',
                'style' => 'background-color: white;'
              ]) }}
          </div>
          <legend class="text-muted">History</legend>
          <div id="ticket-history-list">
          </div>
      </div>
    </div>
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>
  $(document).ready(function(){
    @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    var url = "{{ url('get/ticket/history') }}" + '/' + {{ $id }}

    $.getJSON(url, function(response){
      display = ""
      for( ctr = 0; ctr < response.length; ctr++ )
      {
        display +=    `<div class="list-group">
                        <a href="#" class="list-group-item">
                          <h4 class="list-group-item-heading">` + response[ctr].ticketname + ` <small>` + response[ctr].status +`</small></h4>
                          <p class="list-group-item-text text-justified">` + response[ctr].details + `</p>                          
                          <p class="list-group-item-text">Staff Assigned: ` + response[ctr].user.firstname + " " +response[ctr].user.lastname + `</p>
                          <p class="list-group-item-text text-right">` + response[ctr].author + `</p>
                        </a>
                      </div>`
      }

      $('#ticket-history-list').html('')
      $('#ticket-history-list').append(display)
    });

    $('#page-body').show()
  })
</script>
@stop
