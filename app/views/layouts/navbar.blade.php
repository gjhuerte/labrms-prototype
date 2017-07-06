@if(Auth::check())
	@if(Auth::user()->accesslevel == 0)
		@include('layouts.navbar.admin.default')
	@elseif(Auth::user()->accesslevel == 1)
		@include('layouts.navbar.assistant.default')
	@elseif(Auth::user()->accesslevel == 2)
		@include('layouts.navbar.staff.default')
	@elseif(Auth::user()->accesslevel == 3)
		@include('layouts.navbar.faculty.default')
	@elseif(Auth::user()->accesslevel == 4)
		@include('layouts.navbar.student.default')
	@endif
@else
	@include('layouts.navbar.main.default')
@endif