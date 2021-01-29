<!-- Sidebar Menu -->
<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
			<a href="{{ base_url(ADMIN_PATH.'/dashboard') }}" class="nav-link @isset($menu) {{ $menu == 'dashboard' ? 'active' : '' }} @endisset">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>
					Dashboard
				</p>
			</a>
        </li>
        
        <li class="nav-item">
			<a href="{{ base_url(ADMIN_PATH.'/users') }}" class="nav-link @isset($menu) {{ $menu == 'users' ? 'active' : '' }} @endisset">
				<i class="nav-icon fas fa-users"></i>
				<p>
					Pengguna
				</p>
			</a>
        </li>
        
        <li class="nav-item">
			<a href="{{ base_url(ADMIN_PATH.'/news') }}" class="nav-link @isset($menu) {{ $menu == 'news' ? 'active' : '' }} @endisset">
				<i class="nav-icon fas fa-newspaper"></i>
				<p>
					Berita
				</p>
			</a>
		</li>
        
		<li class="nav-item">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-cogs"></i>
				<p>
					Pengaturan
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="./index.html" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Dashboard v1</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="./index2.html" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Dashboard v2</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="./index3.html" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Dashboard v3</p>
					</a>
				</li>
			</ul>
		</li>
		
		<li class="nav-header">Pengaturan Profile</li>

	</ul>
</nav>
<!-- /.sidebar-menu -->
