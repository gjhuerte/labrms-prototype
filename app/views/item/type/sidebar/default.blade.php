	<div class="col-md-2">
		<div class="panel panel-default panel-shadow" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('item.type.index') }}" class='text-muted'>		Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('item.type.create') }}" class='text-muted'>		Create
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('item.type.view.update') }}" class='text-muted'>
							Update
						</a>
					</li>
					<li role="presentation" id="remove">
						<a href="{{ route('item.type.view.delete') }}" class='text-muted' >
							Remove
						</a>
					</li>
					<li role="presentation" id="restore">
						<a href="{{ route('item.type.view.restore') }}" class='text-muted' >
							Restore
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<script>
		@if(count($active_tab) > 0)
				$('#{{ $active_tab }}').addClass('active');
		@endif
	</script>
