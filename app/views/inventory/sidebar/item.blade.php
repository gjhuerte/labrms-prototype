	<div class="col-sm-2">
		<div class="panel panel-body">
			<div class="list-group">
		        <div class="list-group-item dropdown active">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;">Item <span class="caret"></span></a>
		          <!-- dropdown items -->
		          <ul class="dropdown-menu">
					<li><a class="" id="item" href="{{ url('inventory/item') }}">Overview</a></li>
					<li><a class="" id="item" href="{{ url('inventory/item/create') }}">Create New</a></li>
		          </ul> <!-- end of dropdown items -->
		        </div>
				<a class="list-group-item" id="room" href="{{ url('inventory/room') }}">Room</a>
				<a class="list-group-item" id="lent" href="{{ url('lend/approval') }}">Lent Items</a>
				<a class="list-group-item" id="lostandfound" href="{{ url('item.found') }}">Lost and Found</a>
			</div>
		</div>
	</div>