
@include('layouts.header')

<body class="hold-transition sidebar-mini">
<div class="wrapper">
@include('layouts.nav_bar')
@include('layouts.side_bar')


<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      	<div class="container-fluid">
		        @yield('content')

	    </div>
	</section>
</div>

@include('layouts.footer')
</div>

</body>

