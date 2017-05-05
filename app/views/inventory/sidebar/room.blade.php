	<div class="col-sm-2">
		<div class="panel panel-body">
			<div class="list-group">
				<a class="list-group-item" id="item" href="{{ url('inventory/item') }}">Item</a>
				<a class="list-group-item active	" id="room" href="{{ url('inventory/room') }}">Room</a>
				<a class="list-group-item" id="lent" href="{{ url('lend/approval') }}">Lent Items</a>
				<a class="list-group-item" id="lostandfound" href="{{ url('item.found') }}">Lost and Found</a>
			</div>
		</div>
	</div>