
@section('script')
{{ HTML::script(asset('js/loadingoverlay.min.js')) }}
{{ HTML::script(asset('js/loadingoverlay_progress.min.js')) }}
{{ HTML::script(asset('js/bootstrap-tagsinput.min.js')) }}
{{ HTML::script(asset('js/moment.min.js')) }}
<script type="text/javascript" src="{{ asset('js/standalone/selectize.js') }}"></script>
<script>
	$(document).ready(function(){

		$('#item-list-adder').on('click',function(){
			$('#itemAddModal').modal('hide')
			if($('#propertynumber').val()){
				$('#items').tagsinput('add',$('#propertynumber').val());
			}
		})

		$('#itemAddModal').on('shown.bs.modal', function (e) {

		  $(document).ajaxStart(function(){
		    $.LoadingOverlay("show");
		  });

		  $(document).ajaxStop(function(){
		      $.LoadingOverlay("hide");
		  });

			$.ajax({
				url: '{{ url("get/reservation/item/type/all") }}',
				type: 'get',
				dataType: 'json',
				success: function(response){
					options = '';

					for(ctr = 0;ctr< response.length;ctr++){
						options += "<option value='"+response[ctr].name+"'>"+response[ctr].name+"</option>"
					}

					if(response.length == 0)
					{
						options = "<option value='null'>There are no available item type</option>";
					}

					$('#itemtype').html("")
					$('#itemtype').append(options)
				},
				error: function(){
					$('#itemtype').html("")
					$('#itemtype').append("<option value='null'>There are no available item type</option>")
				},
				complete: function(){
					itembrand();
				}
			})
		})

		function itembrand()
		{
				$.ajax({
					url: '{{ url('get/reservation/item/brand/all') }}',
					type: 'get',
					data:{
						'itemtype': $('#itemtype').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';

						for(ctr = 0;ctr< response.length;ctr++){
							options += "<option value='"+response[ctr].brand+"'>"+response[ctr].brand+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'>There are no available brands</option>";
						}

						$('#itembrand').html("")
						$('#itembrand').append(options)
					},
					error: function(){
						$('#itembrand').html("")
						$('#itembrand').append("<option value='null'>There are no available brands</option>")
					},
					complete: function(){
						itemmodel();
					}
				})
		}

		function itemmodel()
		{
				$.ajax({
					url: '{{ url('get/reservation/item/model/all') }}',
					type: 'get',
					data:{
						'brand': $('#itembrand').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';

						for(ctr = 0;ctr< response.length;ctr++){
							options += "<option value='"+response[ctr].model+"'>"+response[ctr].model+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'>There are no available model</option>";
						}

						$('#itemmodel').html("")
						$('#itemmodel').append(options)
					},
					error: function(){
						$('#itemmodel').html("")
						$('#itemmodel').append("<option value='null'>There are no available model</option>")
					},
					complete: function(){
						propertynumber();
					}
				})
		}

		$('#itemtype').on('change',function(){
			itembrand();
		})

		$('#itembrand').on('change',function(){
			itemmodel();
		});

		$('#itemmodel').on('change',function(){
			propertynumber();
		})

		function propertynumber()
		{
				$.ajax({
					url: '{{ url("get/reservation/item/propertynumber/all") }}',
					type: 'get',
					data: {
						'itemtype': $('#itemtype').val(),
						'brand': $('#itembrand').val(),
						'model': $('#itemmodel').val(),
						'propertynumber': $('#items').val()
					},
					dataType: 'json',
					success: function(response){
						options = '';
						for(ctr = 0;ctr< response.length ;ctr++){
							options += "<option value='"+response[ctr].propertynumber+"'>"+response[ctr].propertynumber+"</option>"
						}

						if(response.length == 0)
						{
							options = "<option value='null'><option value='null'>There are no available property number</option>";
						}
						$('#propertynumber').html("")
						$('#propertynumber').append(options)
					},
					error: function(response){
						$('#propertynumber').html("")
						$('#propertynumber').append("<option value='null'>There are no available property number</option>")
					}
				})
		}


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

		$("#dateofuse").datepicker({
			language: 'en',
			showOtherYears: false,
			todayButton: true,
			autoClose: true,
			onSelect: function(){
				$('#dateofuse').val(moment($('#dateofuse').val(),'MM/DD/YYYY').format('MMMM DD, YYYY'))
			}
		});

		$("#dateofuse").val('{{ Carbon\Carbon::now()->toFormattedDateString() }}');

		$('#starttime').clockpicker({
		    placement: 'bottom',
		    align: 'left',
		    autoclose: true,
		    default: 'now',
            donetext: 'Select',
            init: function(){
            	$('#starttime').val(moment().format("HH:mm"))
            },
            afterDone: function() {
            	error('#time-start-error-message','*Time started must be less than time end')
            },
		});

		$('#endtime').clockpicker({
		    placement: 'bottom',
		    align: 'left',
		    autoclose: true,
		    fromnow: 1800000,
		    default: 'now',
            donetext: 'Select',
            init: function(){
            	$('#endtime').val(moment().add("1800000").format("HH:mm"))
            },
            afterDone: function() {
            	error('#time-end-error-message','*Time ended must be greater than time started')
            },
		});

		function error(attr2,message){
			if($('#endtime').val()){
				if(moment($('#starttime').val(),'HH:mm').isBefore(moment($('#endtime').val(),'HH:mm'))){
					$('#request').show(400);
					$('#time-end-error-message').html(``)
					$('#time-start-error-message').html(``)
					$('#time-end-group').removeClass('has-error');
					$('#time-start-group').removeClass('has-error');
				}else{
					$('#request').hide(400);
					$(attr2).html(message).show(400)
					$('#time-end-group').addClass('has-error');
					$('#time-start-group').addClass('has-error');
				}
			}
		}

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

		init();

		function init(){
	      $.ajax({
	        type: 'get',
	        url: "{{ route('room.index') }}",
	        dataType: 'json',
	        success: function(response){
	          items = "";
	          for(ctr = 0;ctr<response.length;ctr++){
	            items += `<option value=`+response[ctr].name+`>
	            `+response[ctr].name+`
	            </option>`;
	          }

	          if(response.length == 0){
	              items += `<option>There are no available room</option>`
	          }

	          $('#location').html("");
	          $('#location').append(items);
	        },
					complete: function(){

						$('#location').selectize({
								create: true,
								sortField: {
										field: 'text',
										direction: 'asc'
								},
								dropdownParent: 'body'
						})

						$('#location').val({{ Input::old('location') }})
					}
	      });

	      $.ajax({
	        type: 'get',
	        url: "{{ route('faculty.index') }}",
	        dataType: 'json',
	        success: function(response){
	          items = "";
	          for(ctr = 0;ctr<response.length;ctr++){
							lastname = response[ctr].lastname;
							firstname = response[ctr].firstname;
							if(response[ctr].middlename){
								middlename = response[ctr].middlename;
							}else{
								middlename = "";
							}
	            items += `<option value=`+response[ctr].id+`>
	            `+lastname+', '+firstname+' '+middlename+`
	            </option>`;
	          }

	          if(response.length == 0){
	              items += `<option>There are no available faculty</option>`
	          }

	          $('#name').html("");
	          $('#name').append(items);
	        },
					complete: function(){

						$('#name').selectize({
								create: true,
								sortField: {
										field: 'text',
										direction: 'asc'
								},
								dropdownParent: 'body'
						})

						$('#name').val({{ Input::old('name') }})
					}
	      });

	      $.ajax({
	        type: 'get',
	        url: "{{ url('get/purpose/all') }}",
	        dataType: 'json',
	        success: function(response){
	          items = "";
	          for(ctr = 0;ctr<response.length;ctr++){
	            items += `<option value='`+response[ctr].title+`'>
	            `+response[ctr].title+`
	            </option>`;
	          }

	          if(response.length == 0){
	              items += `<option></option>`
	          }

	          $('#purpose').html("");
	          $('#purpose').append(items);
	        },
					complete: function(){

						$('#purpose').selectize({
								create: true,
								sortField: {
										field: 'text',
										direction: 'asc'
								},
								dropdownParent: 'body'
						})

						$('#purpose').val({{ Input::old('purpose') }})
					}
	      });
		}

	});

	$(document).ajaxStop(function(){

		$('#page-body').show();
	});
</script>
@stop
