
@section('script')
<script>
	$(document).ready(function(){

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#show').click(function(){
			$('#reservationCalendarModal').modal('show');
		});

		$('#show-notes').click(function(){
				$('#reservation-info').show();
				$('#hide-notes').show();
				$('#show-notes').hide();
		});

		$('#hide-notes').click(function(){
				$('#reservation-info').hide();
				$('#hide-notes').hide();
				$('#show-notes').show();
		});

		$(function() {
			$( "#dateofuse" ).datepicker({
			  changeMonth: true,
			  changeYear: false,
			  maxAge: 59,
			  minAge: 15,
			});
		});

		$(document).ready(function(){
			$("#dateofuse").val('{{ Carbon\Carbon::now()->toFormattedDateString() }}');
		});

		$('#starttime').timepicker({
			timeFormat: 'h:mm p',
			interval: 30,
			minTime: '7',
			maxTime: '7:00pm',
			defaultTime: '7:00am',
			startTime: '7:00am',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

		$('#endtime').timepicker({
		    timeFormat: 'h:mm p',
		    interval: 30,
		    minTime: '8',
		    maxTime: '9:00pm',
		    defaultTime: '8:00am',
		    startTime: '8:00am',
		    dynamic: false,
		    dropdown: true,
		    scrollbar: true
		});

		$('#request').click(function(){
			swal({
			  title: "Are you sure?",
			  text: "By submitting a request, you acknowledge our condition of three(3) working days in item reservation unless there is a special event or non-working holidays. Disregarding this notice decreases your chance of approval",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Yes, submit it!",
			  cancelButtonText: "No, cancel it!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			  if (isConfirm) {
					$("#reservationForm").submit();
			  } else {
			    swal("Cancelled", "Request Cancelled", "error");
			  }
			});
		});

		$('#page-body').show();

	});
</script>
@stop
