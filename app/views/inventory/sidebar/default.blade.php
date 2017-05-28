
@section('style-include')
{{ HTML::style(asset('css/jquery.sidr.light.min.css')) }}
{{ HTML::style(asset('css/sidr-style.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.sidr.min.js')) }}
{{ HTML::script(asset('js/jquery.hideseek.min.js')) }}
<script src="{{ asset('js/jQuery.succinct.min.js') }}"></script>
@stop
<div id="sidr" hidden>
	<ul id="accordion">
		<li  role="tab" id="item">
			<a class="btn-group btn-group-justified" role="button" id="item-tab">
				<div class="btn-group">
					Item
				</div>
				<div class="btn-group">
					<span class="pull-right glyphicon glyphicon-triangle-right" id="item-icon"></span>
				</div>
			</a>
			<ul role="tabpanel" id="collapseItem">
				<li>
					<a href="{{ route('inventory.item.index') }}" class='text-muted' style="text-decoration: none;" id="itemOverview">Overview</a>
				</li>
				<li>
					<a href="{{ route('inventory.item.create') }}" class='text-muted' style="text-decoration: none;" id="itemProfile">Create</a>
				</li>
			</ul>
		</li>

		<li  role="tab" class="text-muted" id="room">
			<a href="{{ route('inventory.room.index') }}" class="text-muted" id="room-tab">
				Room
			</a>
		</li>

		<li  role="tab" class="text-muted" id="lend">
			<a class="btn-group btn-group-justified" role="button" id="lent-tab">
				<div class="btn-group">
					Lent
				</div>
				<div class="btn-group">
					<span class="pull-right glyphicon glyphicon-triangle-right" id="lent-icon"></span>
				</div>
			<ul role="tabpanel" id="collapseLent" >
					<li><a role="button" href="#" class='text-muted' style="text-decoration: none;" id="lendOverview"> Overview
					</a></li>
					<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;"> Return Item
					</a></li>
			</ul>
		</li>

		<li  role="tab" class="text-muted" id="found">
			<a class="btn-group btn-group-justified" role="button" id="lostAndFound-tab">
				<div class="btn-group">
					Lost And Found
				</div>
				<div class="btn-group">
					<span class="pull-right glyphicon glyphicon-triangle-right" id="lostAndFound-icon"></span>
				</div>
			</a>
			<ul role="tabpanel" id="collapseLostAndFound">
					<li><a role="button" href="#" class='text-muted' style="text-decoration: none;" id="lostAndFoundOverview">	Overview
					</a></li>
					<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;">	Add new item
					</a></li>
					<li><a role="button"  href="#" class='text-muted' style="text-decoration: none;">	Remove Item
					</a></li>
			</ul>
		</li>
	</ul>
</div>

<script>
	$(document).ready(function() {

		@if(count($active_tab) > 0)
		$('#{{ $active_tab }}').addClass('active');
		@endif

	  $('#simple-menu').sidr();

		$('#sidr').show();

		$('#item-tab').on('click',function(){
			if($('#collapseItem').is(':visible')){
				collapseIcon('#item-icon');
				collapseList('#collapseItem');
			}else{
				collapseIcon('#lent-icon','#lostAndFound-icon',null,'#item-icon');
				collapseList('#collapseLostAndFound','#collapseLent',null,'#collapseItem');
			}
		});

		$('#lent-tab').on('click',function(){
			if($('#collapseLent').is(':visible')){
				collapseIcon('#lent-icon');
				collapseList('#collapseLent');
			}else{
				collapseIcon('#item-icon','#lostAndFound-icon',null,'#lent-icon');
				collapseList('#collapseItem','#collapseLostAndFound',null,'#collapseLent');
			}
		});

		$('#lostAndFound-tab').on('click',function(){
			if($('#collapseLostAndFound').is(':visible')){
				collapseIcon('#lostAndFound-icon');
				collapseList('#collapseLostAndFound');
			}else{
				collapseIcon('#item-icon','#lent-icon',null,'#lostAndFound-icon');
				collapseList('#collapseLent','#collapseItem',null,'#collapseLostAndFound');
			}
		});

		@if(count($active_tab) > 0)
				$('#{{ $active_tab }}').addClass('active');
				@if($active_tab == 'item')
					collapseIcon('#lent-icon','#lostAndFound-icon',null,'#item-icon');
					collapseList('#collapseLostAndFound','#collapseLent',null,'#collapseItem');
				@elseif($active_tab == 'room')
					collapseIcon('#lent-icon','#lostAndFound-icon','#item-icon',null);
					collapseList('#collapseLostAndFound','#collapseLent','#collapseItem',null);
				@elseif($active_tab == 'lend')
					collapseIcon('#item-icon','#lostAndFound-icon',null,'#lent-icon');
					collapseList('#collapseItem','#collapseLostAndFound',null,'#collapseLent');
				@elseif($active_tab == 'found')
					collapseIcon('#item-icon','#lent-icon',null,'#lostAndFound-icon');
					collapseList('#collapseLent','#collapseItem',null,'#collapseLostAndFound');
				@endif
		@endif

		function collapseList(item1,item2 = undefined,item3 = undefined,item4 = undefined){
			$(item1).hide(400);
			$(item2).hide(400);
			$(item3).hide(400);
			$(item4).show(400);
		}

		function collapseIcon(item1,item2 = undefined ,item3 = undefined ,item4 = undefined){
			$(item1).switchClass('glyphicon-triangle-bottom','glyphicon-triangle-right')
			$(item2).switchClass('glyphicon-triangle-bottom','glyphicon-triangle-right')
			$(item3).switchClass('glyphicon-triangle-bottom','glyphicon-triangle-right')
			$(item4).switchClass('glyphicon-triangle-right','glyphicon-triangle-bottom')
		}
	});
</script>
