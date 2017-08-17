<style>
  .navbar-fixed-top
  {
    height: 50px;
  }
  /*navbar brand*/
  .navbar-brand
  {
    padding-top: 0;
    padding-left:3;
  }
  .img-size
  {
    width:100%;
    height:50%;
    margin:0;
  }
  .img-responsive
  {
    width:100%;
    height:50%;
    margin:0;
  }
  /* Link Hover*/
  .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
    color: #00b5f0;
  }
  /* Button Hover*/
   .navbar-nav .navbar-right > .btn:hover 
  {
      background-color: #00b5f0;
      border-color: #00b5f0;
      color: rgb(255, 255, 255);
  }
</style>
<!-- navbar for login in -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
       <img src="{{ asset('images/logo/logo-black.png') }}">
      </a>
    </div><!-- end of brand toggle -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse-2">
      <!-- navbar right -->
      <ul class="nav navbar-nav navbar-right">
        <li>{{ link_to('dashboard','Home') }}</li>
        <li>{{ link_to('reservation/create','Reservation') }}</li>
        <li>{{ link_to('ticket/complaint','Complaint') }} </li>
        <li>{{ link_to('logout','Logout') }}</li>

      </ul><!-- end of navbar right -->
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav><!-- /.navbar -->
