@extends('layouts.master-white')
@section('title')
Software information
@stop
@section('navbar')
@include('layouts.navbar')
@stop
@section('content')
<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6">
	@if(count($software) > 0)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Software Information</h3>
			</div>
			<div class="panel-body" style="margin-bottom: 10px;">
				<div class="col-sm-4">
					<label class="text-primary">Name</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $software->name }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Type</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $software->softwaretype }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">License type</label>
				</div>
				<div class="col-sm-8">
					<p class="form-control">{{ $software->licensetype }}</p>
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Requirement</label>
				</div>
				<div class="col-sm-8">
					{{ Form::textarea('text',$software->requirement,[
						'class' => 'form-control',
						'readonly'
					]) }}
				</div>
				<div class="col-sm-4">
					<label class="text-primary">Description</label>
				</div>
				<div class="col-sm-8">
					{{ Form::textarea('text',$software->description,[
						'class' => 'form-control',
						'readonly'
					]) }}
				</div>
				<div class="col-md-12 pull-right">
					{{ Form::button("<<< Go back",[
						'class' => 'btn btn-info btn-lg pull-right btn-link',
						'id' => 'back'
					]) }}
				</div>
			</div>
		</div>
	@endif
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">
	$('#back').click(function(){
		window.location.href = '{{ route('software.index') }}';
	});
	@if( Session::has("success-message") )
	  swal("Success!","{{ Session::pull('success-message') }}","success");
	@endif
	@if( Session::has("error-message") )
	  swal("Oops...","{{ Session::pull('error-message') }}","error");
	@endif
</script>
@stop
