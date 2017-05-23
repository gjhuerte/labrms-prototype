	<div class="col-md-2">
		<div class="panel panel-default panel-shadow" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('faculty.index') }}" class='text-muted'>	<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>	Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('faculty.create') }}" class='text-muted'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	 Create
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('faculty.update-view') }}" class='text-muted'>
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update
						</a>
					</li>
					<li role="presentation" id="remove">
						<a href="{{ route('faculty.delete-view') }}" class='text-muted' >
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
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
