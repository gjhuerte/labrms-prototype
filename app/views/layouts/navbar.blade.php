@if(Auth::check())
	@if(Auth::user()->accesslevel == 0 || Auth::user()->accesslevel == 1 || Auth::user()->accesslevel == 2)
		@include('layouts.navbar.laboffice.default')
	@elseif(Auth::user()->accesslevel == 3)
		@include('layouts.navbar.student.default')
	@elseif(Auth::user()->accesslevel == 4)
		@include('layouts.navbar.student.default')
	@endif
@else
	@include('layouts.navbar.main.default')
@endif