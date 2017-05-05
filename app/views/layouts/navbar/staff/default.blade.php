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
        <!-- maintenance dropdown tab -->
        <li>{{ HTML::link('ticket/create','Generate Ticket') }}
        <!-- maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Inventory <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <li>{{ HTML::link('inventory/item','Item') }}</li>
            <li>{{ HTML::link('inventory/room','Room') }}</li>
            <li>{{ HTML::link('lend/approval','Lent Items') }}
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->
        <!-- tenant maintenance tab -->
        <!-- maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reservation <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- tenant maintenance tab -->
            <li>{{ link_to('reservation/create','Form') }}</li>
            <li>{{ HTML::link('reservation','Approval') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->
        <!-- maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintenance <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- tenant maintenance tab -->
            <li>{{ HTML::link('account','Accounts') }}</li>
            <li>{{ HTML::link('equipment','Equipments') }}
            <li>{{ HTML::link('item/type','Item Types') }}</li>
            <li>{{ link_to('room','Rooms') }}</li>
            <li>{{ link_to('software','Software') }}</li>
            <li>{{ HTML::link('workstation','Workstation') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- tenant maintenance tab -->
            <li>{{ link_to('report/incident','Incident Report') }}</li>
            <li>{{ HTML::link('report/item','Item Master List') }}</li>
            <li>{{ link_to('report/itemprofile','Item Profile') }}</li>
            <li>{{ link_to('report/log','Log Sheet') }}</li>
            <li>{{ link_to('report/roominventory','Room Inventory') }}</li>
            <li>{{ link_to('report/payment','Payment Report') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{{ Auth::user()->firstname." ".Auth::user()->lastname }}} <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <li>{{ link_to('profile','Profile') }}</li>
            <li>{{ link_to('settings','Change Password') }}</li>
            <li role="separator" class="divider"></li>
            <li>{{ link_to('logout','Logout') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->

      </ul><!-- end of navbar right -->
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav><!-- /.navbar -->
