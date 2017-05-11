
@section('script')
<script>
	$(document).ready(function(){

		@if( Session::has("success-message") )
		  swal("Success!","{{ Session::pull('success-message') }}","success");
		@endif
		@if( Session::has("error-message") )
		  swal("Oops...","{{ Session::pull('error-message') }}","error");
		@endif

		$('#show-notes').click(function(){
				$('#reservation-info').show(400);
				$('#hide-notes').show(400);
				$('#show-notes').hide(400);
		});

		$('#hide-notes').click(function(){
				$('#reservation-info').hide();
				$('#hide-notes').hide(400);
				$('#show-notes').show(400);
		});

		$('#show').click(function(){
        $('#reservation').removeClass('col-md-offset-3');
				$('#reservation-info').hide();
				$('#item-search').hide();
				$('#hide').show(0);
				$('#show').hide(400);
				$('#show-notes').hide(400);
				$('#hide-notes').hide(400);
				$('#calendar-panel').fadeIn(400);
				$('#calendar').fullCalendar('render');
		});

		$('#hide').click(function(){
        $('#reservation').addClass('col-md-offset-3');
				$('#item-search').show();
				$('#show').show(400);
				$('#hide').hide(400);
				$('#show-notes').show(400);
				$('#calendar-panel').fadeOut(0);
		});

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'listDay,listWeek,month'
			},

			// customize the button names,
			// otherwise they'd all just say "list"
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},

			defaultDate: '{{ Carbon\Carbon::now()->toDateString() }}',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			theme: true,
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
			itemNameAjaxRequest();
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
