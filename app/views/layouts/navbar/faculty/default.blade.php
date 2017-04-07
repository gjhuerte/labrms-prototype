{{HTML::style(asset('css/navbar-style.css'))}}
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
       <img src="{{ asset('images/logo-new.png') }}">
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
