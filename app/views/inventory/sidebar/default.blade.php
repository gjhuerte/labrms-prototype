	<div class="col-md-2">
		<div class="panel panel-default" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" style="padding-bottom: 10px">
					<li role="presentation" id="item">
						<a class="text-muted" data-toggle="collapse" href="#collapseItem" aria-expanded="false" aria-controls="collapseItem">
					  		<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Item
						</a>
						<ul class="collapse out list-unstyled" id="collapseItem" style="padding: 20px;padding-left: 30px;">
								<li><a href="{{ route('inventory.item.index') }}" class='text-muted' style="text-decoration: none;" id="itemOverview">	Item Overview
								</a></li>
								<hr />
								<li><a href="{{ route('inventory.item.create') }}" class='text-muted' style="text-decoration: none;">	Profile New Item
								</a></li>
						</ul>
					</li>
					
					<li role="presentation" class="text-muted" id="room">
						<a class="text-muted" role="button" data-toggle="collapse" href="#collapseRoom" aria-expanded="false" aria-controls="collapseRoom">
					  		<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Room 
						</a>
						<ul class="collapse out list-unstyled" id="collapseRoom" style="padding: 20px;padding-left: 30px;">
								<li><a role="button" href="{{ route('inventory.room.index') }}" class='text-muted' style="text-decoration: none;" id="roomOverview">	Room Overview
								</a></li>
								<hr />
								<li><a role="button"  href="{{ route('inventory.room.create') }}" class='text-muted' style="text-decoration: none;">	Deploy Item
								</a></li>
						</ul>
					</li>
					
					<li role="presentation" class="text-muted" id="lend">
						<a class="text-muted" role="button" data-toggle="collapse" href="#collapseLent" aria-expanded="false" aria-controls="collapseLent">
					  		<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Lent Item
						</a>
						<ul class="collapse out list-unstyled" id="collapseLent" style="padding: 20px;padding-left: 30px;">
								<li><a role="button" href="{{ url('lend/approval') }}" class='text-muted' style="text-decoration: none;" id="lendOverview"> Overview
								</a></li>
								<hr />
								<li><a role="button"  href="{{ route('inventory.item.create') }}" class='text-muted' style="text-decoration: none;"> Return Item
								</a></li>
						</ul>
					</li>
					
					<li role="presentation" class="text-muted" id="found">
						<a class="text-muted" role="button" data-toggle="collapse" href="#collapseLostAndFound" aria-expanded="false" aria-controls="collapseLostAndFound">
					  		<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Lost and Found
						</a>
						<ul class="collapse out list-unstyled" id="collapseLostAndFound" style="padding: 20px;padding-left: 30px;">
								<li><a role="button" href="#" class='text-muted' style="text-decoration: none;" id="lostAndFoundOverview">	Overview
								</a></li>
								<hr />
								<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;">	Add new item
								</a></li>
								<hr />
								<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;">	Remove Item
								</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<script>
		@if(count($active_tab) > 0)
				$('#{{ $active_tab }}').addClass('active');
				@if($active_tab == 'item')
					$('#itemOverview').addClass('text-primary');
					$('#collapseItem').collapse('show');
				@elseif($active_tab == 'room')
					$('#roomOverview').addClass('text-primary');
					$('#collapseRoom').collapse('show');
				@elseif($active_tab == 'lend')
					$('#lendOverview').addClass('text-primary');
					$('#collapseLent').collapse('show');
				@elseif($active_tab == 'found')
					$('#lostAndFoundOverview').addClass('text-primary');
					$('#collapseLostAndFound').collapse('show');
				@endif
		@endif
	</script>