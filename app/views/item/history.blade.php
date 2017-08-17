@extends('layouts.master-blue')
@section('title')
Item History
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
    <div class="panel panel-body table-responsive">
      <legend class="text-muted"><h3>Item Profile History</h3></legend>
      <ul class="breadcrumb">
        <li><a href="{{ url('item/profile') }}">Items Profile</a></li>
        <li class="active">{{ $itemprofile->propertynumber }}</li>
      </ul>
      <table class="table table-hover table-bordered" id="itemProfileTable" cellspacing="0" width="100%">
        <thead>
          <tr rowspan="2">
              <th class="text-left" colspan="4">Property Number:  
                <span style="font-weight:normal">{{ $itemprofile->propertynumber }}</span> 
              </th>
              <th class="text-left" colspan="4">Brand:  
                <span style="font-weight:normal">{{ $itemprofile->inventory->brand }}</span> 
              </th>
          </tr>
          <tr rowspan="2">
              <th class="text-left" colspan="4">Serial Number:  
                <span style="font-weight:normal">{{ $itemprofile->serialnumber }}</span>  
              </th>
              <th class="text-left" colspan="4">Model:  
                <span style="font-weight:normal">{{ $itemprofile->inventory->model }}</span> 
              </th>
          </tr>
          <tr rowspan="2">
              <th class="text-left" colspan="4">Item Type:  
                <span style="font-weight:normal">{{ $itemprofile->inventory->itemtype->name }}</span>  
              </th>
              <th class="text-left" colspan="4">Warranty: 
                <span style="font-weight:normal">{{ $itemprofile->warranty }}</span> 
              </th>
          </tr>
          <tr rowspan="2">
              <th class="text-center" colspan="12">Ticket Details</th>
          </tr>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Details</th>
            <th>Author</th>
            <th>Staff Assigned</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        @forelse($itemprofile->ticket as $ticket)
          <tr>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->ticketname }}</td>
            <td>{{ $ticket->details }}</td>
            <td>{{ $ticket->author }}</td>
            <td>{{ $ticket->user->firstname }} {{ $ticket->user->lastname }}</td>
            <td>{{ $ticket->status }}</td>
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
<script>
  $(document).ready(function(){

    $('#itemProfileTable').DataTable();
    @if( Session::has("success-message") )
      swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
      swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('#page-body').show()
  })
</script>
@stop
