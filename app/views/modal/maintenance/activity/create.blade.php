{{ HTML::style(asset('css/animate.css')) }}
<div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 style="color:#337ab7;">Create an Activity</h3>
			</div>
			<div class="modal-body">
			{{ Form::open(['method'=>'post','route'=>'maintenance.activity.store','class'=>'form-horizontal']) }}
				<!-- Title -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('type','Maintenance Type') }}
					</div>
					<div class="col-sm-6">
					  <input type="radio" id="corrective" name="maintenancetype" value='corrective' checked/> Corrective
					</div>
					<div class="col-sm-6">
					  <input type="radio" id="preventive" name="maintenancetype" value='preventive' /> Preventive
					</div>
				</div>
				<div id="preventive-info" class="col-sm-12 alert alert-success" role="alert" hidden>
					Machine maintenance or the preventive maintenance (PM) has the following meanings:
					<ul>
						<li>
						The care and servicing by personnel for the purpose of maintaining equipment in satisfactory operating condition by providing for systematic inspection, detection, and correction of incipient failures either before they occur or before they develop into major defects.
						</li>
						<li>
						Preventive maintenance tends to follow planned guidelines from time-to-time to prevent equipment and machinery breakdown
						</li>
						<li>
						The work carried out on equipment in order to avoid its breakdown or malfunction. It is a regular and routine action taken on equipment in order to prevent its breakdown.
						</li>
						<li>
						Maintenance, including tests, measurements, adjustments, parts replacement, and cleaning, performed specifically to prevent faults from occurring.
						</li>
					</ul>
				</div>
				<div class="col-sm-12 alert alert-warning" role="alert" id="corrective-info">
					Corrective maintenance is a maintenance task performed to identify, isolate, and rectify a fault so that the failed equipment, machine, or system can be restored to an operational condition within the tolerances or limits established for in-service operations
				</div>
				<!-- Company -->
				<div class="form-group">
					<div class="col-sm-12">
					{{ Form::label('problem','Problem / Category') }}
					{{ Form::textarea('problem',Input::old('problem'),[
						'class'=>'form-control',
						'placeholder'=>'Problem or Category'
					]) }}
					</div>
				</div>
				<div class="form-group">
					<div class=" col-md-12">
						<button type="submit" class="btn btn-lg btn-primary btn-block">Create</button>
					</div>
				</div>
			{{ Form::close() }}
			</div> <!-- end of modal-body -->
		</div> <!-- end of modal-content -->
	</div>
</div>
<script>
$('#createActivityModal').on('show.bs.modal',function(){
	$('input[type=radio]').on('change',function(){
		console.log($('#preventive').is(':checked'))
		if($('#preventive').is(':checked'))
		{
			$('#corrective-info').hide()
			$('#preventive-info').show().animateCSS('fadeIn')
		} else {

			$('#preventive-info').hide()
			$('#corrective-info').show().animateCSS('fadeIn')
		}
	})

    $.fn.extend({
        animateCSS: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });
})
</script>