@extends('layouts.master-blue')
@section('title')
Ticket History
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
@section('content')
<div class="container-fluid" id="page-body">
  <div class="col-md-12">
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
          <legend><h3 class="text-muted">Ticket {{ $ticket->id }}</h3></legend>
          <ol class="breadcrumb">
              <li><a href="{{ url('ticket') }}">Ticket</a></li>
              <li>{{ $id }}</li>
              <li class="active">History</li>
          </ol>
          <p class="text-muted">Note: The top most entry is the latest ticket</p>
          <table class="table table-hover table-striped table-bordered table-condensed" id="ticketTable" cellspacing="0" width="100%">
            <thead>
                  <tr rowspan="2">
                      <th class="text-left" colspan="4">Ticket Name:  
                        <span style="font-weight:normal">{{ $ticket->ticketname }}</span> 
                      </th>
                      <th class="text-left" colspan="4">Ticket Type:  
                        <span style="font-weight:normal">{{ $ticket->tickettype }}</span> 
                      </th>
                  </tr>
                  <tr rowspan="2">
                      <th class="text-left" colspan="4">Details:  
                        <span style="font-weight:normal">{{ $ticket->details }}</span>  
                      </th>
                      <th class="text-left" colspan="4"> 
                      </th>
                  </tr>
                    <tr>
                <th>ID</th>
                <th>Details</th>
                <th>Type</th>
                <th>Staff Assigned</th>
                <th>Author</th>
                <th>Date Created</th>
                <th>Status</th>
              </tr>
            </thead>
          </table>
      </div>
    </div>
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
{{ HTML::script(asset('js/moment.min.js')) }}
<script>
  $(document).ready(function(){
    @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif


    var table = $('#ticketTable').DataTable({
      select: {
        style: 'single'
      },
      language: {
          searchPlaceholder: "Search..."
      },
      order: [ [ 0,"desc" ] ],
      "dom": "<'row'<'col-sm-2'l><'col-sm-7'<'toolbar'>><'col-sm-3'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
     "processing": true,
      ajax: "{{ url('ticket/history') }}" + '/' + {{ $id }},
      columns: [
          { data: "id" },
          { data: "details" },
          { data: "tickettype" },
          { data: function(callback){
            return callback.user.firstname + " " + callback.user.middlename + " " + callback.user.lastname
          } },
          { data: "author" },
          {data: function(callback){
            return moment(callback.created_at).format("dddd, MMMM Do YYYY");
          }},
          { data: "status" }
      ],
    });


    $('#page-body').show()
  })
</script>
@stop
