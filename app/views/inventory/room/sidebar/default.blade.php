
@section('style-include')
{{ HTML::style(asset('css/jquery.sidr.light.min.css')) }}
{{ HTML::style(asset('css/sidr-style.min.css')) }}
@stop
@section('script-include')
{{ HTML::script('js/moment.min.js') }}
{{ HTML::script(asset('js/jquery.sidr.min.js')) }}
@stop
<div id="sidr" hidden>
	<ul>
		<li role="presentation" id="overview">
			<a href="{{ route('inventory.item.index') }}" class='text-muted'>	Go back to Inventory
			</a>
		</li>
      @foreach($rooms as $room)
		<li role="presentation">
			<a class="room" data-id='{{ $room->id }}'>{{ $room->name }}</a>
		</li>
    @endforeach
	</ul>
</div>
<script>
$(document).ready(function() {

	@if(count($active_tab) > 0)
	$('#{{ $active_tab }}').addClass('active');
	@endif

  $('#simple-menu').sidr();
	$('#sidr').show();
});
</script>
