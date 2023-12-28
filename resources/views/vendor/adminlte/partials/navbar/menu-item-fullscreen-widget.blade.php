<li class="nav-item lang-div">
	<a href="#" class="a" data-toggle="dropdown">
		<i data-feather="globe"></i>
		{{ Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : 'Lang' }}
		<i class="fa fa-angle-down lft-10"></i>
	</a>
	<ul class="dropdown-menu" style="left: -30px !important; right: 0 !important;">
		<li>
			<a href="{{ route('lang.admin.change', 'en') }}">English</a>
		</li>
		<li>
			<a href="{{ route('lang.admin.change', 'ar') }}">Arabic</a>
		</li>
	</ul>
</li>

<li class="nav-item">
	<a class="nav-link" data-widget="fullscreen" href="#" role="button">
		<i class="fas fa-expand-arrows-alt"></i>
	</a>
</li>

<style>
	.nav-item {
		position: relative;
	}

	.lang-div .dropdown-menu {
		position: absolute;
		top: 30px !important;
		width: fit-content;
		text-align: center;
		left: -30px !important;
		min-width: 100px !important;
		right: 0 !important;
	}

	.lang-div .dropdown-menu.show {
		left: -30px !important;
		right: 0 !important;
	}

	.lang-div .dropdown-menu li {
		text-align: center;
	}
</style>
