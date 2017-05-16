	<div class="col-md-2 hidden-xs">
		<div class="panel panel-default panel-shadow ">
			<div class="panel-heading">
				<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" id="overview">
						<a href="{{ route('account.index') }}" class='text-muted'>	<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Overview
						</a>
					</li>
					<li role="presentation" id="add">
						<a href="{{ route('account.create') }}" class='text-muted'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 	New Account
						</a>
					</li>
					<li role="presentation" id="update">
						<a href="{{ route('account.view.update') }}" class='text-muted'>
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update
						</a>
					</li>
					<li role="presentation" id="activation">
						<a href="{{ route('account.retrieveInactiveAccount') }}" class='text-muted' >
							<span class="glyphicon glyphicon-star" aria-hidden="true"></span> Activation
						</a>
					</li>
					<li role="presentation" id="adminpriviledge">
						<a href="#" class='text-muted' >
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Access Level
						</a>
					</li>
					<li role="presentation" id="penalty">
						<a href="#" class='text-muted' >
							<span class="glyphicon glyphicon-ruble" aria-hidden="true"></span> Penalty
						</a>
					</li>
					<li role="presentation" id="remove">
						<a href="{{ route('account.view.delete') }}" class='text-muted'>
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
						</a>
					</li>
					<li role="presentation" id="restore">
						<a href="{{ route('account.retrieveDeleted') }}" class='text-muted'>
							<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Restore
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
