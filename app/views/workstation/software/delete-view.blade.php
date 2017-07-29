@extends('layouts.master-blue')
@section('title')
Software Removal
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('style')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
<style>
  #page-body{
    display: none;
  }
</style>
@stop
@section('content')
<div class="container-fluid" id="page-body">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6 panel panel-body ">
      @include('workstation.sidebar.default')
      <div class="col-sm-12" >
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
        <div class="col-md-12 col-xs-12" style="padding: 5px;margin-bottom: 20px;background-color: #04789b;color: white;">
          <div class="col-sm-4 col-xs-6">
            <h3 class="text-center">Software</h3>
          </div>
          <div class="col-sm-4 col-xs-6">
            <h3 class="text-center">License Key</h3>
          </div>
        </div>
        <div id="table-body">
          @forelse($software as $software)
          <div role="button" class="col-xs-12 item center-block software-row" style="padding: 20px;box-shadow:0;border:1px solid #e5e5e5;margin: 10px 0px;">
            <div class="col-sm-4 col-xs-6">
              <p class="text-center text-muted">{{ $software->name }}</p>
            </div>
            <div class="col-sm-4 col-xs-6">
              <p class="text-center text-muted">{{ $software->key }}</p>
            </div>
            <div class="col-sm-4 col-xs-12">
              <button class="btn btn-danger btn-block delete" data-pc="{{ $software->pcid }}" data-software="{{ $software->softwareid }}" data-license="{{ $software->licensekeyid }}"><span class="glyphicon glyphicon-trash"></span> Uninstall</button>
            </div>
          </div>
          @empty
          <div role="button" class="col-xs-12 center-block">
            <p class="text-center text-muted">No Record Found</p>
          </div>
          @endforelse
        </div>
      </div>
    </div> <!-- centered  -->
  </div><!-- Row -->
</div><!-- Container -->
@stop
@section('script')
<script>
  $(document).ready(function(){

    $('.item').on('mouseover',function(event){
      $(this).css("box-shadow","2px 2px 2px 1px rgba(0, 0, 0, 0.2)");
    })

    $('.item').on('mouseout',function(event){
      $(this).css("box-shadow","");
    })

    @if( Session::has("success-message") )
        swal("Success!","{{ Session::pull('success-message') }}","success");
    @endif
    @if( Session::has("error-message") )
        swal("Oops...","{{ Session::pull('error-message') }}","error");
    @endif

    $('.delete').on('click',function(){
      var pc = $(this).data('pc');
      var software = $(this).data('software');
      var license = $(this).data('license');
      var object = $(this).parent().parent('.software-row');
      $.ajax({
        url: '{{ url("workstation/software/") }}'+'/'+pc+'/remove',
        type: 'delete',
        data: {
          'software': software,
          'softwarelicense': license
        },
        dataType: 'json',
        success: function(response){
          if(response.length == 0)
          {
            swal('Server Error','Server did not respond to your request. Reload this page.','error')
          }else{
            object.remove();
            swal('Operation success','Software removed from workstation','success');
          }
        },
        error: function(){
          swal('Error Occurred','Problem encountered while sending your data.','error')
        }
      })
    });

    $('#page-body').show();

  });
</script>
@stop
