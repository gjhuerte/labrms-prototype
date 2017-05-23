
@section('style-include')
{{ HTML::style(asset('css/jquery.sidr.light.min.css')) }}
{{ HTML::style(asset('css/sidr-style.min.css')) }}
@stop
@section('script-include')
{{ HTML::script(asset('js/jquery.sidr.min.js')) }}
@stop
<div id="sidr" hidden>
	<ul>
		<li role="presentation" id="overview">
			<a href="{{ route('room.index') }}" class='text-muted'>		Overview
			</a>
		</li>
		<li role="presentation" id="add">
			<a href="{{ route('room.create') }}" class='text-muted'>		Create
			</a>
		</li>
		<li role="presentation" id="update">
			<a href="{{ route('room.view.update') }}" class='text-muted'>
				Update
			</a>
		</li>
		<li role="presentation" id="remove">
			<a href="{{ route('room.view.delete') }}" class='text-muted' >
				Remove
			</a>
		</li>
		<li role="presentation" id="restore">
			<a href="{{ route('room.view.restore') }}" class='text-muted' >
				Restore
			</a>
		</li>
	</ul>
</div>

<div class="col-md-12" style="margin-bottom: 10px;">
	<button class="btn btn-default" id="simple-menu" href="#sidr"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <span id="nav-text">Toggle Navigation</span></button>
</div>

<script>
$(document).ready(function() {

	@if(count($active_tab) > 0)
	$('#{{ $active_tab }}').addClass('active');
	@endif

  $('#simple-menu').sidr();

	$('#simple-menu').click(function(){
		changeClass('#itemtype-info','col-md-12','col-md-9');
	});

	function changeClass(id,oldClass,newClass)
	{
		if($(id).hasClass(oldClass))
		{
			$('#nav-text').html('Hide Navigation');
			$(id).removeClass(oldClass);
			$(id).addClass(newClass);
		}else{
			$('#nav-text').html('Toggle Navigation');
			$(id).addClass(oldClass);
			$(id).removeClass(newClass);
		}
	}

	$('#sidr').show();
});
</script>
