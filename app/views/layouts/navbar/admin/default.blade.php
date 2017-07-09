<style>
  /*navbar brand*/
  .navbar-brand-zero
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
   Button Hover
   .navbar-nav .navbar-right > .btn:hover
  {
      background-color: #00b5f0;
      border-color: #00b5f0;
      color: rgb(255, 255, 255);
  }
</style>
<link rel="shortcut icon" href="{{ asset('images/logo/logo-black.png') }}"; />
 <!-- navbar for login in -->
<nav class="navbar navbar-default" style="border:none;border-radius:0px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2" style="border: none;">
        <span class="sr-only">Toggle navigation</span>
        <span class="glyphicon glyphicon-tasks"></span>
      </button>
      <p role="none" class="navbar-brand navbar-brand-zero" href="#">
       <img class="img" src="{{ asset('images/logo/logo-black.png') }}">
      </p>
    </div><!-- end of brand toggle -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse-2">
      <!-- navbar left -->
      <ul class="nav navbar-nav">
        <!-- home tab -->
        <li>
          <a href="{{ url('dashboard') }}"><img class="img" src="{{ asset('images/logo/Dashboard/dashboard-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Dashboard</a>
        </li>

        <!-- reservation dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <img class="img" src="{{ asset('images/logo/Reservation/reservation-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Reservation <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- create tab -->
            <li>{{ link_to('reservation/create','Form') }}</li>
            <!-- view all reservation -->
            <li>{{ HTML::link('reservation/view/all','Approval') }}</li>
            <!-- view all reservation items -->
            <li>{{ HTML::link('reservation/items/list','Item Filter') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of reservation dropdown tab -->

        <!-- ticket dropdown tab -->
        <li>
          <a href="{{ url('ticket') }}"><img class="img" src="{{ asset('images/logo/Ticket/ticket-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Ticketing</a>
        </li> <!-- end of ticket dropdown tab -->

        <!-- inventory dropdown tab -->
        <li>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="img" src="{{ asset('images/logo/Inventory/inventory-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Inventory <span class="caret"></span>
          </a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- tenant inventory tab -->
            <li>{{ link_to('inventory/item','Item') }}</li>
            <li>{{ link_to('workstation','Workstation') }}</li>
            <li>{{ HTML::link('inventory/room','Room') }}</li>
            <li>{{ HTML::link('supplies','Supplies') }}</li>
            <li>{{ link_to('lostandfound','Lost And Found') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of inventory dropdown tab -->

        <!-- maintenance dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <img class="img" src="{{ asset('images/logo/Maintenance/maintenance-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Maintenance <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- maintenance tab -->
            <li>{{ link_to('equipment/support','Maintenance Activities') }}</li>
            <li>{{ link_to('item/type','Item Types') }}</li>
            <li>{{ HTML::link('schedule','Subject Offering') }}</li>
            <li>{{ link_to('room','Laboratory Room') }}</li>
            <li>{{ link_to('purpose','Reservation Purpose') }}</li>
            <li>{{ link_to('software','Software') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->

        <!-- utilities dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <img class="img" src="{{ asset('images/logo/Utilities/utilities-16.png') }}" style="width:25px;height:25px;margin-right: 5px;"> Utilities <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- utilities tab -->
            <li>{{ link_to('account','Accounts') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of utilities dropdown tab -->
      </ul>
      <!-- navbar right -->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle text-capitalize" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <img class="img" src="{{ asset('images/logo/LabHead/labhead-icon-16.png') }}" style="width:25px;height:25px;margin-right: 5px;">{{{ Auth::user()->firstname }}} {{{ Auth::user()->lastname }}}<span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <li>{{ link_to('profile','Profile') }}</li>
            <li>{{ link_to('settings','Settings') }}</li>
            <li>{{ link_to('reports','Reports') }}</li>
            <li>{{ link_to('help','Help') }}</li>
            <li role="separator" class="divider"></li>
            <li>{{ link_to('logout','Logout') }}</li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of maintenance dropdown tab -->

      </ul><!-- end of navbar right -->
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav><!-- /.navbar -->
<script>
</script>