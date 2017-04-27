	<div class="col-md-2">
		<div class="panel panel-default" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('schedule.index') }}" class='text-muted'>	Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('schedule.create') }}" class='text-muted'>	 Create
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('schedule.update-view') }}" class='text-muted'>
							Update
						</a>
					</li>
					<li role="presentation" id="remove">
						<a href="{{ route('schedule.delete-view') }}" class='text-muted' >
							Remove
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