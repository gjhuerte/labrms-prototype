	<div class="col-md-2">
		<div class="panel panel-default panel-shadow" style="border: none;">
			<div class="panel-heading">
				Navigation
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked panel-group"  id="accordion" role="tablist" aria-multiselectable="true" style="padding-bottom: 10px">
					<li  role="tab" id="item">
						<a class="text-muted" role="button" data-parent="#accordion" data-toggle="collapse" href="#collapseItem" aria-expanded="false" aria-controls="collapseItem" id="item-tab">
					  	<span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="item-icon" style="display:none;"></span>	Item
						</a>
						<ul class="collapse out panel-collapse list-unstyled"  role="tabpanel" id="collapseItem" style="padding: 20px;padding-left: 30px;">
								<li><a href="{{ route('inventory.item.index') }}" class='text-muted' style="text-decoration: none;" id="itemOverview">	Overview
								</a></li>
								<hr />
								<li><a href="{{ route('inventory.item.create') }}" class='text-muted' style="text-decoration: none;" id="itemProfile">	Create
								</a></li>
						</ul>
					</li>

					<li  role="tab" class="text-muted" id="room">
						<a href="{{ route('inventory.room.index') }}" class="text-muted" id="room-tab">
					  	Room
						</a>
					</li>

					<li  role="tab" class="text-muted" id="lend">
						<a class="text-muted" role="button" data-parent="#accordion" data-toggle="collapse" href="#collapseLent" aria-expanded="false" aria-controls="collapseLent" id="lent-tab">
					  		<span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="lent-icon" style="display:none;"></span>	Lent Item
						</a>
						<ul class="collapse out panel-collapse list-unstyled"  role="tabpanel" id="collapseLent" style="padding: 20px;padding-left: 30px;">
								<li><a role="button" href="#" class='text-muted' style="text-decoration: none;" id="lendOverview"> Overview
								</a></li>
								<hr />
								<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;"> Return Item
								</a></li>
						</ul>
					</li>

					<li  role="tab" class="text-muted" id="found">
						<a class="text-muted" role="button" data-parent="#accordion" data-toggle="collapse" href="#collapseLostAndFound" aria-expanded="false" aria-controls="collapseLostAndFound" id="lostAndFound-tab">
					  		<span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="lostAndFound-icon" style="display:none;"></span>	Lost and Found
						</a>
						<ul class="collapse out panel-collapse list-unstyled"  role="tabpanel" id="collapseLostAndFound" style="padding: 20px;padding-left: 30px;">
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
		$(document).ready(function(){

				$('#item-tab').on('mouseover',function(){
					collapse('show','hide','hide');
					$('#item-icon').show(200);
				});

				$('#item-tab').on('mouseout',function(){
					$('#item-icon').hide(200);
				});

				$('#lent-tab').on('mouseover',function(){
					collapse('hide','show','hide');
					$('#lent-icon').show(200);
				});

				$('#lent-tab').on('mouseout',function(){
					$('#lent-icon').hide(200);
				});

				$('#lostAndFound-tab').on('mouseover',function(){
					collapse('hide','hide','show');
					$('#lostAndFound-icon').show(200);
				});

				$('#lostAndFound-tab').on('mouseout',function(){
					$('#lostAndFound-icon').hide(200);
				});
		});

		function collapse(item,lent,lostAndFound){
			$('#collapseItem').collapse(item);
			$('#collapseLent').collapse(lent);
			$('#collapseLostAndFound').collapse(lostAndFound);
		}

		@if(count($active_tab) > 0)
				$('#{{ $active_tab }}').addClass('active');
				@if($active_tab == 'item')
					$("#{{ (!empty($tab)) ? $tab : 'none' ; }}").addClass('text-primary');
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
