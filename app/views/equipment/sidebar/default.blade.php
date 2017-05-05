	<div class="col-md-2">
		<div class="panel panel-default" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('equipment.index') }}" class='text-muted'>	Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('equipment.create') }}" class='text-muted'>Add Equipment
						</a>
					</li>
					<li role="presentation" id="deploy">
						<a href="{{ route('equipment.deploy-view') }}" class='text-muted' >
							Deployment
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('equipment.update-view') }}" class='text-muted'>
							Update
						</a>
					</li>
					<li role="presentation" id="condemn">
						<a href="{{ route('equipment.condemn-view') }}" class='text-muted' >
							Condemn
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