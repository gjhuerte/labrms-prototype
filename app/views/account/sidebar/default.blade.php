	<div class="col-md-2">
		<div class="panel panel-default" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('account.index') }}" class='text-muted'>	Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('account.create') }}" class='text-muted'>	New Account
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('account.update-view') }}" class='text-muted'>
							Update
						</a>
					</li>
					<li role="presentation" id="activation">
						<a href="{{ route('account.retrieveInactiveAccount') }}" class='text-muted' >
							Activation
						</a>
					</li>
					<li role="presentation" id="adminpriviledge">
						<a href="#" class='text-muted' >
							Access Level
						</a>
					</li>
					<li role="presentation" id="penalty">
						<a href="#" class='text-muted' >
							Penalty
						</a>
					</li>
					<li role="presentation" id="remove">
						<a href="{{ route('account.delete-view') }}" class='text-muted'>
							Remove
						</a>
					</li>
					<li role="presentation" id="restore">
						<a href="{{ route('account.retrieveDeleted') }}" class='text-muted'>
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