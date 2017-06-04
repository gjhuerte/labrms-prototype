
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
			<a href="{{ route('equipment.support.index') }}" class='text-muted'>	Overview
			</a>
		</li>
		<li role="presentation" id="add">
			<a href="{{ route('equipment.support.create') }}" class='text-muted'>	 Create
			</a>
		</li>
		<li role="presentation" id="update">
			<a href="{{ route('equipment.support.view.update') }}" class='text-muted'>
				Update
			</a>
		</li>
		<li role="presentation" id="remove">
			<a href="{{ route('equipment.support.view.delete') }}" class='text-muted' >
				Remove
			</a>
		</li>
	</ul>
</div>

<div class="col-md-12" style="margin-bottom: 10px;">
	<button class="btn btn-flat btn-default" id="simple-menu" href="#sidr" style="padding: 10px;"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <span id="nav-text">Toggle Navigation</span></button>
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
