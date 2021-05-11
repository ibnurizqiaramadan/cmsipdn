@include('admin.layouts.head')
@include('admin.layouts.js')
<div class="nanobar loadingGan" id="loadingGan" style="position: fixed;">
    <div class="bar"></div>
</div>
<div id="customCss"></div>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge">15</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
							<span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
							<span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
							<span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="fas fa-power-off"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
						<a href="#" class="dropdown-item" id="btnLogout">
							<i class="fas fa-sign-out-alt mr-2"></i> Logout
						</a>
					</div>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="{{ base_url() }}" class="brand-link" target="_blank">
				<img src="{{ getAssetsFiles('img/mainlogo.png') }}" alt="AdminLTE Logo"
					class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">IPDN</span>
			</a>
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="{{ base_url('assets/img/user.png') }}" class="img-circle elevation-2"
							alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">{{ $_SESSION['name'] }}</a>
					</div>
				</div>
				<div id="navSection">
					@include('admin/layouts/nav')
				</div>
			</div>
			<!-- /.sidebar -->
		</aside>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-12">
							<ol class="breadcrumb" id="rotiId">
								@foreach ($roti as $menu => $link)
								@php $param = explode(":", $menu);$target = $param[1] == 'blank' ? '_blank' : '';@endphp
								<li class="breadcrumb-item"> {!! $link != '' ? "<a class='roti' href='$link' target='$target'>" . $param[0] . "</a>" : $param[0] !!}</li>
								@endforeach
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->
			<!-- Main content -->
			<section class="content" id="contentId">
				@yield('content')
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 1.0.0
			</div>
		</footer>
	</div>
	<!-- ./wrapper -->
</body>
</html>