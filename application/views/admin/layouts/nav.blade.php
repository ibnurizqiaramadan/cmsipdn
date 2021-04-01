<!-- Sidebar Menu -->
<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
			<a href="{{ base_url(ADMIN_PATH.'/dashboard') }}" class="nav-link menu-item @isset($menu) {{ $menu == 'dashboard' ? 'active' : '' }} @endisset">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>
					Dashboard
				</p>
			</a>
        </li>
        
        <li class="nav-item">
			<a href="{{ base_url(ADMIN_PATH.'/users') }}" class="nav-link menu-item @isset($menu) {{ $menu == 'users' ? 'active' : '' }} @endisset">
				<i class="nav-icon fas fa-users"></i>
				<p>
					Pengguna
				</p>
			</a>
        </li>

		<li class="nav-item @isset($menu) {{ $menu == 'post' ? 'menu-open' : '' }} @endisset">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa-paper-plane"></i>
				<p>
					Post
					<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ base_url(ADMIN_PATH.'/category') }}" class="nav-link menu-item @isset($subMenu) {{ $subMenu == 'category' ? 'active' : '' }} @endisset">
						<i class="fas fa-tags nav-icon"></i>
						<p>Kategori</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ base_url(ADMIN_PATH.'/news') }}" class="nav-link menu-item @isset($subMenu) {{ $subMenu == 'news' ? 'active' : '' }} @endisset">
						<i class="fas fa-newspaper nav-icon"></i>
						<p>Berita</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ base_url(ADMIN_PATH.'/event') }}" class="nav-link menu-item @isset($subMenu) {{ $subMenu == 'event' ? 'active' : '' }} @endisset">
						<i class="fas fa-calendar-check nav-icon"></i>
						<p>Event</p>
					</a>
				</li>
			</ul>
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
